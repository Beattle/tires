/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('ajax-form', require('./components/form.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app'
});

window.editRow = (el) => {
    if(el.dataset.edit){
        return
    }
    el.dataset.edit = true
    el.removeAttribute('data-foo');
    let row = $(el).closest('tr')
    let cells = row.children('td[data-name]:empty')
    for (let cell of cells) {
        let value = cell.textContent
        cell.textContent = ''
        cell.insertAdjacentHTML('afterbegin',
            `<input form="form-${row[0].dataset.id}" class="form-control" type="text" name="${cell.dataset.name}" value="${value}" />`)
    }
    let form = updateForm(row[0].dataset.id)
    form.prop('hidden',false)
    form = $(`<tr><td class="text-center" colspan="12">${form[0].outerHTML}</td>`)
    row.after(form)


}

window.updateForm = (id)=>{
    let form = $('form.update').clone()
    form.find('[name=id]').val(id)
    form.attr('id','form-'+id)
    return form
}
