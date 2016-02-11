Ext.define('myapp.view.actividad.ListaResponsablePlan', {
    extend: 'Ext.grid.Panel',
    alias: 'widget.listaResponsablePlan',
    itemId: 'listaResponsablePlan',
    requires: [
        'Ext.selection.CellModel',
        'Ext.selection.CheckboxModel',
        'Ext.ux.ajax.SimManager',
    ],
    store: Ext.create('myapp.store.actividad.PlanResponsableStore'),
    emptyText: 'No hay empleado(s) asignado(s) a esta actividad',
    columnLines: true,
    initComponent: function () {
        var me = this;
        me.columns = me.buildColumns();
        me.dockedItems = me.buildDockedItems();
        me.callParent();
    },
    buildColumns: function () {
        return [{
                xtype: 'rownumberer'
            },
            {
                flex: 0.5,
                dataIndex: 'fecha',
                text: 'Fecha de Asignación',
            },
            {
                flex: 0.5,
                dataIndex: 'idEmpleado',
                hidden: true

            },
            {
                flex: 0.5,
                dataIndex: 'idUsuario',
                hidden: true

            },
            {
                text: 'Foto',
                dataIndex: 'foto',
                flex: 0.3,
                renderer: function (value, metadata, record) {
                    return '<img width="50" height="50" src="../../empleados/_DSC' + value + '">';
                }
            }, {
                flex: 0.8,
                dataIndex: 'nombrecompleto',
                text: 'Nombre y apellido',
            }

        ]
    },
    buildDockedItems: function () {
        return [{
                xtype: 'toolbar',
                dock: 'top',
                store: this.store,
                displayInfo: true,
                items: [
                    {
                        xtype: 'button',
                        name: 'btnAsignarResponsable',
                        text: 'Asignar Empleado',
                        iconCls: 'useradd1'
                    },
                    {
                        xtype: 'button',
                        name: 'btnEliminarResponsable',
                        text: 'Eliminar Empleado',
                        iconCls: 'icon-eliminarUs',
                        hidden: true
                    },
                    {
                        xtype: 'label',
                        name: 'lblIdActividad',
                        text: '',
                        hidden: true

                    },
                    {
                        xtype: 'label',
                        name: 'lblIdEvento',
                        text: '',
                        hidden: true

                    },
                    {
                        xtype: 'label',
                        name: 'lblEvento',
                        text: '',
                        hidden: true

                   },
                ]
            }

        ];
    }
});