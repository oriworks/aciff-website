<?php

namespace Oriworks\NewsletterSystem\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Oriworks\NewsletterSystem\Models\Email;
use Oriworks\NewsletterSystem\Models\MailingList;

class MailingListImport implements ToCollection
{
    /**
     * @var MailingList
     */
    private $mailingList;

    public function __construct(MailingList $mailingList) {
        $this->mailingList = $mailingList;
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $row)
        {
            $emails = explode(';', $row[0]);
            foreach ($emails as $email) {

                $emailModel = Email::firstOrCreate([
                    'email' => trim($email),
                ]);

                $emailModel->mailingLists()->syncWithoutDetaching($this->mailingList->id);
            }
        }
    }

}
