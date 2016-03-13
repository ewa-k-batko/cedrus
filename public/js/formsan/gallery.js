var frs = frs || {};
frs.gallery = frs.pot || {};
frs.gallery.cnf = function () {
    var self = this;
    self.getForm = function () {
        return {
            head: {
                //action: '/formsan#/',
                legend: 'Galeria Edycja'},
            items: [
                {type: 'text',
                    label: 'id',
                    name: 'id',
                   // model: 'field.id',
                    value: ''}, 
                {type: 'text',
                    label: 'nazwa',
                    name: 'name',
                    //model: 'field.name',
                    value: 'wpisz tekst'},
                {type: 'textarea',
                    label: 'opis',
                    name: 'description',
                    value: ''},
                {type: 'hidden',
                   // label: 'ikona',
                    name: 'mdl',
                    value: 'setStuff'},
                {type: 'radio-group',
                    label: 'status',
                    name: 'status',
                    elements: [
                        {label: 'aktywny', value: 'A'},
                        {label: 'usunięty', value: 'D'},
                        {label: 'utworzony', value: 'C'}
                    ]
                },
                {type: 'multifile',
                    label: 'dodaj zdjęcia',
                    name: 'files',
                    value: ''}
            ],
            params: [
                {name: 'mdl', value: 'setCategory'}
            ]

        }
    },
    self.setSelect = function (obj, pos, elements, current){
        obj['items'][pos]['elements'] = elements; 
        obj['items'][pos]['selected'] = {id: current.id, name: current.name};
        return obj;
    };

    return this;
}

 