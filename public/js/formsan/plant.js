var frs = frs || {};
frs.plant = frs.plant || {};
frs.plant.cnf = function () {
    var self = this;
    self.getForm = function () {
        return {
            head: {
                //action: '/formsan#/',
                legend: 'Roślina Edycja'},
            items: [
                {type: 'text',
                    label: 'id',
                    name: 'id',
                   // model: 'field.id',
                    value: ''},
                {type: 'select',
                    label: 'kategoria',
                    name: 'category',
                   // model: 'field.name',
                    selected: {},
                    elements: [
                        {name: 'nazwa kategorii', id: 'id kategorii'}
                    ]},
                {type: 'text',
                    label: 'nazwa',
                    name: 'name',
                    //model: 'field.name',
                    value: 'wpisz tekst'},
                {type: 'text',
                    label: 'nazwa łacińska',
                    name: 'namelt',
                    //model: 'field.name',
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
                    value: 'setPlant'},
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
    },
    self.setSelect = function (obj, pos, elements, current){
        obj['items'][pos]['elements'] = elements; 
        obj['items'][pos]['selected'] = {id: current.id, name: current.name};
        return obj;
    }

    return this;
}

 