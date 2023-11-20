import IndexField from './components/IndexField'
import DetailField from './components/DetailField'
import FormField from './components/FormField'

Nova.booting((app, store) => {
  app.component('index-multiple-input', IndexField)
  app.component('detail-multiple-input', DetailField)
  app.component('form-multiple-input', FormField)
})
