<?php

namespace App\Console\Commands;

use App\Models\Banner;
use App\Models\Gallery;
use App\Models\Information;
use App\Models\MenuItem;
use App\Models\Page;
use App\Models\Partnership;
use App\Models\PartnershipAddress;
use App\Models\PartnershipArea;
use App\Models\PartnershipContact;
use Carbon\Carbon;
use ClassicO\NovaMediaLibrary\API;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ImportData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // DB::connection('aciff')->update("update banners_left set new_id = null where 1");
        // DB::connection('aciff')->update("update banners_footer set new_id = null where 1");
        // DB::connection('aciff')->update("update galeria set new_id = null where 1");
        // DB::connection('aciff')->update("update section set new_id = null where 1");
        // DB::connection('aciff')->update("update news set new_id = null where 1");
        // DB::connection('aciff')->update("update deals set new_id = null where 1");
        // DB::connection('aciff')->update("update menu set new_id = null where 1");
        // Gallery::query()->delete();
        // Page::query()->delete();
        // Information::query()->delete();
        // Banner::query()->delete();
        MenuItem::query()->delete();
        // PartnershipArea::query()->delete();
        // Partnership::query()->delete();
        // PartnershipAddress::query()->delete();
        // PartnershipContact::query()->delete();

        $this->importGalleries();

        $this->importPages();
        $this->importInformation();

        $this->importBanners('banners_left', 'side');
        $this->importBanners('banners_footer', 'bottom');

        $this->importMenu();
        $this->importPartners();
    }

    private function importGalleries() {
        collect(DB::connection('aciff')->select("select * from galeria where new_id is NULL"))->each(function ($data) {
            $created = Gallery::create([
                "name" => $data->evento,
                "subtitle" => $data->legenda,
                "publish_to" => $data->online ? null : Carbon::now(),
            ]);

            $created
                ->addMediaFromUrl("http://aciff.pt/{$data->foto}")
                ->toMediaCollection('gallery');


            DB::connection('aciff')->update("update galeria set new_id = ? where id = ?", [$created->id, $data->id]);

            $this->info("Gallery: {$data->evento} with {$created->id}");
        });
    }

    private function importPages() {
        collect(DB::connection('aciff')->select("select * from section where new_id is NULL"))->each(function ($data) {
            $htmlLogo = $this->importImageByWidth($data->logotipo, 250, 'pages');
            $htmlFooter = $this->importImageByHeight($data->img_footer, 50, 'pages', true);

            $htmlOtherImages = collect(DB::connection('aciff')->select("select * from section_attach where section_id = ? and type_attach_id = 1", [$data->id]))->reduce(function ($agg, $item) {
                $html = $this->importImageByWidth($item->attach_upload, 250, 'pages');
                if ($item->online) {
                    return $agg . $html;
                }
                return $agg;
            }, "");

            $created = Page::create([
                "subject" => $data->title,
                "content" => "<p><span style=\"float: right; width: 250px; margin-left: 10px;\">{$htmlLogo}{$htmlOtherImages}</span>{$data->text}{$htmlFooter}</p>",
                "publish_to" => $data->online ? null : Carbon::now(),
                'view' => $data->id === 16 ? 'contact-form' : 'page',
                "keywords" => [$data->title],
            ]);

            collect(DB::connection('aciff')->select("select * from section_attach where section_id = ? and type_attach_id <> 1", [$data->id]))->each(function ($item) use ($created) {
                $created
                    ->addMediaFromUrl("http://aciff.pt/{$item->attach_upload}")
                    ->withCustomProperties(['published' => $item->online, 'description' => $item->nome])
                    ->toMediaCollection('page_attachments');
            });


            DB::connection('aciff')->update("update section set new_id = ? where id = ?", [$created->id, $data->id]);

            $this->info("Page: {$data->title} with {$created->id}");
        });
    }

    private function importInformation() {
        collect(DB::connection('aciff')->select("select * from news where new_id is NULL"))->each(function ($data) {
            $this->info("Start Information: {$data->id} {$data->title}");
            try {
                $htmlOtherImages = collect(DB::connection('aciff')->select("select * from news_attach where news_id = ? and ficheiro REGEXP '^uploads/.*\\.(png|jpg|gif)$'", [$data->id]))->reduce(function ($agg, $item) {
                    $html = $this->importImageByWidth($item->ficheiro, 250, 'information');
                    return $agg . $html;
                }, "");

                $created = Information::create([
                    "subject" => $data->title,
                    "content" => "<p><span style=\"float: right; width: 250px; margin-left: 10px;\">{$htmlOtherImages}</span>{$data->text}</p>",
                    "publish_at" => new Carbon($data->datein),
                    "highlight_at" => new Carbon($data->datein),
                    "highlight_to" => new Carbon($data->dateout),
                    "keywords" => preg_split("/[,|;][\s]*/", $data->keywords),
                ]);

                collect(DB::connection('aciff')->select("select * from news_attach where news_id = ? and ficheiro REGEXP '^uploads/.*\\.(pdf|zip|docx)$'", [$data->id]))->each(function ($item) use ($created) {
                    $encode = implode("/", array_map("rawurlencode", explode("/", $item->ficheiro)));
                    $created
                        ->addMediaFromUrl("http://aciff.pt/{$encode}")
                        ->withCustomProperties(['published' => true, 'description' => $item->ficheiro_titulo])
                        ->toMediaCollection('attachments');
                });


                DB::connection('aciff')->update("update news set new_id = ? where id = ?", [$created->id, $data->id]);

                $this->info("Information: {$data->title} with {$created->id}");
            } catch (\Throwable $th) {
                dd($th);
            }
        });
    }

    private function importMenu() {
        collect(DB::connection('aciff')->select("select * from menu where new_id is NULL order by nordem"))->each(function ($data) {
            if ($data->subsubmenu) {
                $menu = MenuItem::firstOrCreate([
                    "name" => $data->menu
                ]);
                $parent = MenuItem::firstOrCreate([
                    "name" => $data->submenu
                ]);
                $parent->parent()->associate($menu)->save();
                $item = MenuItem::create([
                    "name" => $data->subsubmenu
                ]);
                $item->parent()->associate($parent)->save();
            } else if ($data->submenu) {
                $parent = MenuItem::firstOrCreate([
                    "name" => $data->menu
                ]);
                $item = MenuItem::create([
                    "name" => $data->submenu
                ]);
                $item->parent()->associate($parent)->save();
            } else {
                $item = MenuItem::create([
                    "name" => $data->menu
                ]);
            }
            preg_match('/^section.php\?id\=(.*)$/', $data->link, $matches);
            if(count($matches)) {
                if ($matches[1] == '12') {
                    $protocolsAndPartnerships = Page::where('subject', 'Protocolos e Parcerias')->first();
                    if (!$protocolsAndPartnerships) {
                        $protocolsAndPartnerships = Page::create(['subject' => 'Protocolos e Parcerias', 'content' => '', 'view' => 'protocols-and-partnerships', 'keywords' => ['Protocolos', 'Parcerias']]);
                    }
                    $item->page()->associate($protocolsAndPartnerships->id);
                } elseif ($matches[1] == '13') {
                    $membershipForm = Page::where('subject', 'Ficha de Adesão')->first();
                    if (!$membershipForm) {
                        $membershipForm = Page::create(['subject' => 'Ficha de Adesão', 'content' => '', 'view' => 'membership-form', 'keywords' => ['Adesão']]);
                    }
                    $item->page()->associate($membershipForm->id);
                } else {
                    collect(DB::connection('aciff')->select("select new_id from section where id = ?", [$matches[1]]))->each(function ($section) use ($item) {
                        $item->page()->associate($section->new_id);
                    });
                }
            } else {
                if ($data->link === 'index.php') {
                    $inicio = Page::where('subject', 'Início')->first();
                    if (!$inicio) {
                        $inicio = Page::create(['subject' => 'Início', 'content' => '', 'view' => 'home', 'keywords' => ['Início']]);
                    }
                    $item->page()->associate($inicio);
                } else if ($data->link === 'archive.php') {
                    $news = Page::where('subject', 'Notícias')->first();
                    if (!$news) {
                        $news = Page::create(['subject' => 'Notícias', 'content' => '', 'view' => 'information-list', 'keywords' => ['Noticias']]);
                    }
                    $item->page()->associate($news);
                } else {
                    $item->link = $data->link;
                }
            }

            $this->info("Menu {$data->link}: {$data->menu} > {$data->submenu} > {$data->subsubmenu}");
            $item->save();
        });
    }

    private function importPartners() {
        $area = PartnershipArea::firstOrCreate([
            "name" => "Não definido"
        ]);
        collect(DB::connection('aciff')->select("select * from deals where new_id is NULL"))->each(function ($data) use ($area) {
            $created = Partnership::create([
                "type" => $data->type_id == 1 ? 'partnership' : 'protocol',
                "name" => $data->name,
                "site" => $data->site,
                "email" => $data->email,
                "benefits" => $data->benefits,
                "comments" => $data->obs,
            ]);

            $created->area()->associate($area);
            $created->save();

            if ($data->logotipo) {
                $created
                    ->addMediaFromUrl($data->logotipo)
                    ->toMediaCollection('partner_logo');
            }

            if ($data->contact_tel_name1) {
                PartnershipContact::create([
                    "name" => $data->contact_tel_name1,
                    "value" => $data->contact_tel_num1,
                    "partnership_id" => $created->id,
                ]);
            }

            if ($data->contact_tel_name2) {
                PartnershipContact::create([
                    "name" => $data->contact_tel_name2,
                    "value" => $data->contact_tel_num2,
                    "partnership_id" => $created->id,
                ]);
            }

            if ($data->contact_tel_name3) {
                PartnershipContact::create([
                    "name" => $data->contact_tel_name3,
                    "value" => $data->contact_tel_num3,
                    "partnership_id" => $created->id,
                ]);
            }

            if ($data->address_name_1) {
                PartnershipAddress::create([
                    "name" => $data->address_name_1,
                    "value" => $data->address_add_1,
                    "partnership_id" => $created->id,
                ]);
            }

            if ($data->address_name_2) {
                PartnershipAddress::create([
                    "name" => $data->address_name_2,
                    "value" => $data->address_add_2,
                    "partnership_id" => $created->id,
                ]);
            }

            if ($data->address_name_3) {
                PartnershipAddress::create([
                    "name" => $data->address_name_3,
                    "value" => $data->address_add_3,
                    "partnership_id" => $created->id,
                ]);
            }

            if ($data->address_name_4) {
                PartnershipAddress::create([
                    "name" => $data->address_name_4,
                    "value" => $data->address_add_4,
                    "partnership_id" => $created->id,
                ]);
            }


            DB::connection('aciff')->update("update deals set new_id = ? where id = ?", [$created->id, $data->id]);

            $this->info("Partnerships: {$data->name} with {$created->id}");
        });
    }

    private function importBanners($table, $position) {
        collect(DB::connection('aciff')->select("select * from {$table} where new_id is NULL"))->each(function ($banner) use ($table, $position) {
            $link = $banner->link;
            preg_match('/^section.php\?id\=(.*)$/', $banner->link, $matches);
            if(count($matches)) {
                $link = collect(DB::connection('aciff')->select("select new_id from section where id = ?", [$matches[1]]))->map(function ($section) {
                    $page = Page::where('id', $section->new_id)->first();
                    return env('APP_URL') . '/' . $page->slug;
                })->first();
            }
            preg_match('/^archive.php\?id\=(.*)$/', $banner->link, $matches);
            if(count($matches)) {
                $link = collect(DB::connection('aciff')->select("select new_id from news where id = ?", [$matches[1]]))->map(function ($section) {
                    $information = Information::where('id', $section->new_id)->first();
                    return env('APP_URL') . '/noticias/' . $information->slug;
                })->first();
            }


            $createdBanner = Banner::create([
                "name" => $banner->name,
                "publish_to" => $banner->online && !$banner->end ? null : Carbon::now(),
                "position" => $position,
                "link" => $link
            ]);

            $createdBanner
                ->addMediaFromUrl("http://aciff.pt/{$banner->foto}")
                ->toMediaCollection('banner');


            DB::connection('aciff')->update("update {$table} set new_id = ? where id = ?", [$createdBanner->id, $banner->id]);

            $this->info("Banner: {$banner->name} with {$createdBanner->id}");
        });
    }

    private function importImageByHeight($image, $height, $folder, $footer = false) {
        if($image) {
            $encode = implode("/", array_map("rawurlencode", explode("/", $image)));
            $imageModel = API::upload("http://aciff.pt/{$encode}", $folder);
            $width = $height / $imageModel->options->wh[1] * $imageModel->options->wh[0];
            if ($footer) {
                return "<img style=\"margin: auto; margin-top: 20px\" src=\"{$imageModel->url}\" width=\"{$width}\" height=\"{$height}\">";
            } else {
                return "<img style=\"float: right;\" src=\"{$imageModel->url}\" width=\"{$width}\" height=\"{$height}\">";
            }
        }
        return "";
    }

    private function importImageByWidth($image, $width, $folder, $footer = false) {
        if($image) {
            $encode = implode("/", array_map("rawurlencode", explode("/", $image)));
            $imageModel = API::upload("http://aciff.pt/{$encode}", $folder);
            $height = $width / $imageModel->options->wh[0] * $imageModel->options->wh[1];
            if ($footer) {
                return "<img style=\"margin: auto; margin-top: 20px\" src=\"{$imageModel->url}\" width=\"{$width}\" height=\"{$height}\">";
            } else {
                return "<img style=\"float: right;\" src=\"{$imageModel->url}\" width=\"{$width}\" height=\"{$height}\">";
            }
        }
        return "";
    }
}
