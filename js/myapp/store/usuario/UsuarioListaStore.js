Ext.define('myapp.store.usuario.UsuarioListaStore', {
    extend: 'Ext.data.Store',    
    model: 'myapp.model.store.usuario.UsuarioListaStore',
    storeId: 'tipousuario',
    autoLoad: true,
    proxy: {
        type: 'ajax',
        url: BASE_URL + 'registrar/usuario/buscarusuario',
        reader: {
            type: 'json',
            root: 'data'
        }
    }
});
