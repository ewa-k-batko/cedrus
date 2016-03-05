var frs = frs || {};
frs.category = frs.category || {};
frs.category.cnf = function () {
    var self = this;
    self.getForm = function () {
        return {
            head: {
                //action: '/formsan#/',
                legend: 'Kategorie Edycja'},
            items: [
                {type: 'text',
                    label: 'id',
                    name: 'id',
                    model: 'field.id',
                    value: ''},
                {type: 'text',
                    label: 'nazwa',
                    name: 'name',
                    model: 'field.name',
                    value: 'wpisz tekst'},
                {type: 'textarea',
                    label: 'opis',
                    name: 'description',
                    value: ''},
                {type: 'text',
                    label: 'url',
                    name: 'url',
                    value: ''},
                {type: 'text',
                    label: 'ikona',
                    name: 'icon',
                    value: ''},
                {type: 'hidden',
                   // label: 'ikona',
                    name: 'mdl',
                    value: 'setCategory'},
                {type: 'radio-group',
                    label: 'status',
                    name: 'status',
                    elements: [
                        {label: 'aktywny', value: 'A'},
                        {label: 'usunięty', value: 'D'},
                        {label: 'utworzony', value: 'C'}
                    ]
                }
            ],
            params: [
                {name: 'mdl', value: 'setCategory'}
            ]

        }
    }

    return this;
}

 