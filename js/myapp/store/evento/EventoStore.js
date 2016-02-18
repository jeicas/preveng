Ext.define('myapp.store.evento.EventoStore', {
    extend: 'Ext.data.Store',
    model: 'myapp.model.store.evento.EventoListaModel',
    proxy: { 
        type:'ajax', 
        url: BASE_URL + 'evento/evento/listaEventos',
        reader: {
            type:'json', 
            root: 'data'
        }
    },
    root: {
        text: 'Tree display of Countries',
        id: 'myTree',
        expanded: true
    },
    folderSort: true,
    sorters: [{
        property: 'text',
        direction: 'ASC'
    }],
    autoLoad: true
});