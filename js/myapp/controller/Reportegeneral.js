Ext.define('myapp.controller.reportes.Reportegeneral', {
    extend: 'Ext.app.Controller',
    views: [
        'reportes.Reportegeneral',
        'reportes.WinCriteriosEvento'],
    controller: [
    ],
    requires: [
        'myapp.util.Util',
        'myapp.util.Md5'
    ], refs: [
        {
            ref: 'WinCriteriosEvento',
            selector: 'winCriteriosEvento'
        },
        {
            ref: 'WinCriterioActividad',
            selector: 'winCriterioActividad'
        },
    ],
    init: function () {
        this.control({
            "reportegeneral button[name=btnEvento]": {
                click: this.reporteEvento
            }, "reportegeneral button[name=btnActividad]": {
                click: this.reportePlan
            },
            "winCriteriosEvento button[name=btnGenerar]": {
                click: this.generarReporteEvento
            },
            "winCriteriosEvento button[name=btnLimpiar]": {
                click: this.onClickLimpiar
            },
            "winCriterioActividad button[name=btnGenerarAct]": {
                click: this.onClickGenerarAct
            },
            "winCriterioActividad button[name=btnLimpiarAct]": {
                click: this.onClickLimpiarAct
            },
        });
    },
    reporteEvento: function (grupo, cmp) {
        win = Ext.create('myapp.view.reportes.WinCriteriosEvento');
        win.show();

    },
     reportePlan: function (grupo, cmp) {
        win = Ext.create('myapp.view.reportes.WinCriterioActividad');
        win.show();

    },
    onClickLimpiar: function (grupo, cmp) {
        formulario = this.getWinCriteriosEvento();
        formulario.down('form[name=formulario]').getForm().reset();
    },
    
    onClickLimpiarAct: function (grupo, cmp) {
        formulario = this.getWinCriterioActividad();
        formulario.down('form[name=formulario]').getForm().reset();
    },
    
    onClickGenerarAct: function (grupo, cmp) {
         form = this.getWinCriterioActividad();
          idEv = form.down('combobox[name=cmbEvento]').getValue();
          nEv = form.down('combobox[name=cmbEvento]').getRawValue();
        //console.log(idEv);  
        if (idEv!=null)
          {
                window.open(BASE_URL + 'pdfs/reportegeneralMetaActividad/generarReporteActividadEvento?idEv='+idEv);
          }else {
               window.open(BASE_URL + 'pdfs/reportegeneralMetaActividad/generarReporteActividadTodo');
          }
       

    },
    generarReporteEvento: function (grupo, cmp) {
        form = this.getWinCriteriosEvento();
        tipoE = form.down('combobox[name=cmbTipoEvento]').getValue();
        sector = form.down('combobox[name=cmbSector]').getValue();
        alcance = form.down('combobox[name=cmbAlcance]').getValue();
        fecha = form.down('textfield[name=dtfFechaT]').getValue();
        agente = form.down('combobox[name=cmbAgente]').getValue();
        estatus = form.down('combobox[name=cmbEstatus]').getValue();

        ntipoE = form.down('combobox[name=cmbTipoEvento]').getRawValue();
        nsector = form.down('combobox[name=cmbSector]').getRawValue();
        nalcance = form.down('combobox[name=cmbAlcance]').getRawValue();
        nagente = form.down('combobox[name=cmbAgente]').getRawValue();
        nestatus = form.down('combobox[name=cmbEstatus]').getRawValue();

        if (tipoE != null && sector != null && alcance != null && fecha != null && agente != null && estatus != null) {
            window.open(BASE_URL + 'pdfs/reportegeneral/generarReporteEventoGeneralSeleccionTodos?sector=' + sector + '&alcance=' + alcance + '&fecha=' + fecha + '&agente=' + agente + '&estatus=' + estatus + '&tipoEvento=' + tipoE + '&nsector=' + nsector + '&nalcance=' + nalcance + '&nagente=' + nagente + '&nestatus=' + nestatus + '&ntipoEvento=' + ntipoE + '');
        } else {
            //========================================Tipo de Evento parte 1================================================    
            if (tipoE != null && sector == null && alcance == null && fecha == null && agente == null && estatus == null) {
                window.open(BASE_URL + 'pdfs/reportegeneral/generarReporteEventoGeneralSeleccionTipoEvento?tipoEvento=' + tipoE + '&ntipoEvento=' + ntipoE + '');
            }
            else {
                if (tipoE != null && sector != null && alcance == null && fecha == null && agente == null && estatus == null) {
                    window.open(BASE_URL + 'pdfs/reportegeneral/generarReporteEventoGeneralSeleccionTipoEventoSector?sector=' + sector + '&tipoEvento=' + tipoE + '&ntipoEvento=' + ntipoE + '&nsector=' + nsector + '');
                } else {
                    if (tipoE != null && sector != null && alcance == null && fecha == null && agente != null && estatus == null) {
                        window.open(BASE_URL + 'pdfs/reportegeneral/generarReporteEventoGeneralSeleccionTipoEventoSectorAgente?sector=' + sector + '&tipoEvento=' + tipoE + '&ntipoEvento=' + ntipoE + '&nsector=' + nsector + '&agente=' + agente + '&nagente=' + nagente + '');
                    } else {
                        if (tipoE != null && sector != null && alcance != null && fecha == null && agente != null && estatus == null) {
                            window.open(BASE_URL + 'pdfs/reportegeneral/generarReporteEventoGeneralSeleccionTipoEventoSectorAgenteAlcance?sector=' + sector + '&tipoEvento=' + tipoE + '&ntipoEvento=' + ntipoE + '&nsector=' + nsector + '&alcance=' + alcance + '&nalcance=' + nalcance + '&agente=' + agente + '&nagente=' + nagente + '');
                        } else {
                            if (tipoE != null && sector != null && alcance != null && fecha == null && agente != null && estatus != null) {
                                window.open(BASE_URL + 'pdfs/reportegeneral/generarReporteEventoGeneralSeleccionTipoEventoSectorAgenteAlcanceEstatus?sector=' + sector + '&tipoEvento=' + tipoE + '&ntipoEvento=' + ntipoE + '&nsector=' + nsector + '&alcance=' + alcance + '&nalcance=' + nalcance + '&agente=' + agente + '&nagente=' + nagente + '&estatus=' + estatus + '&nestatus=' + nestatus + '');
                            } else {

                                if (tipoE != null && sector == null && alcance != null && fecha == null && agente == null && estatus == null) {
                                    window.open(BASE_URL + 'pdfs/reportegeneral/generarReporteEventoGeneralSeleccionTipoEventoAlcance?alcance=' + alcance + '&tipoEvento=' + tipoE + '&ntipoEvento=' + ntipoE + '&nalcance=' + nalcance + '');
                                } else {
                                    if (tipoE != null && sector == null && alcance == null && fecha != null && agente == null && estatus == null) {
                                        window.open(BASE_URL + 'pdfs/reportegeneral/generarReporteEventoGeneralSeleccionTipoEventoFecha?fecha=' + fecha + '&tipoEvento=' + tipoE + '&ntipoEvento=' + ntipoE + '');
                                    } else {
                                        if (tipoE != null && sector == null && alcance == null && fecha == null && agente != null && estatus == null) {
                                            window.open(BASE_URL + 'pdfs/reportegeneral/generarReporteEventoGeneralSeleccionTipoEventoAgente?agente=' + agente + '&tipoEvento=' + tipoE + '&ntipoEvento=' + ntipoE + '&nagente=' + nagente + '');
                                        } else {
                                            if (tipoE != null && sector == null && alcance == null && fecha == null && agente == null && estatus != null) {
                                                window.open(BASE_URL + 'pdfs/reportegeneral/generarReporteEventoGeneralSeleccionTipoEventoEstatus?estatus=' + estatus + '&tipoEvento=' + tipoE + '&ntipoEvento=' + ntipoE + '&nestatus=' + nestatus + '');
                                            } else {
                                                if (tipoE != null && sector == null && alcance != null && fecha == null && agente != null && estatus == null) {
                                                    window.open(BASE_URL + 'pdfs/reportegeneral/generarReporteEventoGeneralSeleccionTipoEventoAgenteAlcance?agente=' + agente + '&tipoEvento=' + tipoE + '&ntipoEvento=' + ntipoE + '&alcance=' + alcance + '&nagente=' + nagente + '&nalcance=' + nalcance + '');
                                                } else {
                                                    if (tipoE != null && sector == null && alcance == null && fecha == null && agente != null && estatus != null) {
                                                        window.open(BASE_URL + 'pdfs/reportegeneral/generarReporteEventoGeneralSeleccionTipoEventoAgenteEstatus?estatus=' + estatus + '&tipoEvento=' + tipoE + '&ntipoEvento=' + ntipoE + '&nestatus=' + nestatus + '&nagente=' + nagente + '&agente=' + agente + '');
                                                    } else {
                                                        if (tipoE != null && sector == null && alcance == null && fecha != null && agente != null && estatus == null) {
                                                            window.open(BASE_URL + 'pdfs/reportegeneral/generarReporteEventoGeneralSeleccionTipoEventoAgenteFecha?agente=' + agente + '&tipoEvento=' + tipoE + '&ntipoEvento=' + ntipoE + '&nagente=' + nagente + '&fecha=' + fecha + '');
                                                        } else {
                                                            ////==================================================================Agente===========================================================
                                                            if (tipoE == null && sector == null && alcance == null && fecha == null && agente != null && estatus == null) {
                                                                window.open(BASE_URL + 'pdfs/reportegeneral/generarReporteEventoGeneralSeleccionAgente?agente=' + agente + '&nagente=' + nagente + '');
                                                            } else {
                                                                if (tipoE == null && sector == null && alcance == null && fecha == null && agente != null && estatus != null) {
                                                                    window.open(BASE_URL + 'pdfs/reportegeneral/generarReporteEventoGeneralSeleccionAgenteEstatus?estatus=' + estatus + '&agente=' + agente + '&nagente=' + nagente + '&nestatus=' + nestatus + '');
                                                                } else {
                                                                    if (tipoE == null && sector != null && alcance == null && fecha == null && agente != null && estatus == null) {
                                                                        window.open(BASE_URL + 'pdfs/reportegeneral/generarReporteEventoGeneralSeleccionAgenteSector?sector=' + sector + '&agente=' + agente + '&nagente=' + nagente + '&nsector=' + nsector + '');
                                                                    } else {
                                                                        if (tipoE == null && sector == null && alcance != null && fecha == null && agente != null && estatus == null) {
                                                                            window.open(BASE_URL + 'pdfs/reportegeneral/generarReporteEventoGeneralSeleccionAgenteAlcance?alcance=' + alcance + '&agente=' + agente + '&nagente=' + nagente + '&nalcance=' + nalcance + '');
                                                                        } else {
                                                                            if (tipoE == null && sector == null && alcance == null && fecha != null && agente != null && estatus == null) {
                                                                                window.open(BASE_URL + 'pdfs/reportegeneral/generarReporteEventoGeneralSeleccionAgenteFecha?fecha=' + fecha + '&agente=' + agente + '&nagente=' + nagente + '');
                                                                            } else {
                                                                                if (tipoE == null && sector != null && alcance != null && fecha != null && agente != null && estatus != null) {
                                                                                    window.open(BASE_URL + 'pdfs/reportegeneral/generarReporteEventoGeneralSeleccionAgenteAlcanceSectorEstatusFecha?sector=' + sector + '&alcance=' + alcance + '&fecha=' + fecha + '&agente=' + agente + '&estatus=' + estatus + '&nsector=' + nsector + '&nalcance=' + nalcance + '&nagente=' + nagente + '&nestatus=' + nestatus + '');
                                                                                } else {
                                                                                    if (tipoE == null && sector != null && alcance != null && fecha == null && agente != null && estatus != null) {
                                                                                        window.open(BASE_URL + 'pdfs/reportegeneral/generarReporteEventoGeneralSeleccionAgenteAlcanceSectorEstatus?sector=' + sector + '&alcance=' + alcance + '&agente=' + agente + '&estatus=' + estatus + '&nsector=' + nsector + '&nalcance=' + nalcance + '&nagente=' + nagente + '&nestatus=' + nestatus + '');
                                                                                    } else {
                                                                                        if (tipoE == null && sector == null && alcance != null && fecha != null && agente != null && estatus != null) {
                                                                                            window.open(BASE_URL + 'pdfs/reportegeneral/generarReporteEventoGeneralSeleccionAgenteAlcanceEstatusFecha?alcance=' + alcance + '&agente=' + agente + '&estatus=' + estatus + '&nalcance=' + nalcance + '&nagente=' + nagente + '&nestatus=' + nestatus + '&fecha=' + fecha + '');
                                                                                        } else {
                                                                                            if (tipoE == null && sector != null && alcance != null && fecha != null && agente != null && estatus == null) {
                                                                                                window.open(BASE_URL + 'pdfs/reportegeneral/generarReporteEventoGeneralSeleccionAgenteAlcanceSectorFecha?alcance=' + alcance + '&agente=' + agente + '&estatus=' + estatus + '&nalcance=' + nalcance + '&nagente=' + nagente + '&nestatus=' + nestatus + '&fecha=' + fecha + '&sector=' + sector + '&nsector=' + nsector + '');
                                                                                            } else {
                                                                                                if (tipoE == null && sector != null && alcance == null && fecha != null && agente != null && estatus != null) {
                                                                                                    window.open(BASE_URL + 'pdfs/reportegeneral/generarReporteEventoGeneralSeleccionAgenteSectorEstatusFecha?agente=' + agente + '&estatus=' + estatus + '&nagente=' + nagente + '&nestatus=' + nestatus + '&fecha=' + fecha + '&sector=' + sector + '&nsector=' + nsector + '');
                                                                                                } else {
                                                                                                    if (tipoE == null && sector != null && alcance != null && fecha == null && agente != null && estatus == null) {
                                                                                                        window.open(BASE_URL + 'pdfs/reportegeneral/generarReporteEventoGeneralSeleccionAgenteAlcanceSector?agente=' + agente + '&nagente=' + nagente + '&sector=' + sector + '&nsector=' + nsector + '&alcance=' + alcance + '&nalcance=' + nalcance + '');
                                                                                                    } else {
                                                                                                        if (tipoE == null && sector == null && alcance != null && fecha != null && agente != null && estatus == null) {
                                                                                                            window.open(BASE_URL + 'pdfs/reportegeneral/generarReporteEventoGeneralSeleccionAgenteAlcanceFecha?agente=' + agente + '&nagente=' + nagente + '&fecha=' + fecha + '&alcance=' + alcance + '&nalcance=' + nalcance + '');
                                                                                                        } else {
                                                                                                            if (tipoE == null && sector == null && alcance != null && fecha == null && agente != null && estatus != null) {
                                                                                                                window.open(BASE_URL + 'pdfs/reportegeneral/generarReporteEventoGeneralSeleccionAgenteAlcanceEstatus?agente=' + agente + '&nagente=' + nagente + '&estatus=' + estatus + '&nestatus=' + nestatus + '&alcance=' + alcance + '&nalcance=' + nalcance + '');
                                                                                                            } else {
                                                                                                                if (tipoE == null && sector != null && alcance == null && fecha == null && agente != null && estatus != null) {
                                                                                                                    window.open(BASE_URL + 'pdfs/reportegeneral/generarReporteEventoGeneralSeleccionAgenteSectorEstatus?agente=' + agente + '&nagente=' + nagente + '&estatus=' + estatus + '&nestatus=' + nestatus + '&sector=' + sector + '&nsector=' + nsector + '');
                                                                                                                } else {
                                                                                                                    if (tipoE == null && sector != null && alcance == null && fecha != null && agente != null && estatus == null) {
                                                                                                                        window.open(BASE_URL + 'pdfs/reportegeneral/generarReporteEventoGeneralSeleccionAgenteSectorFecha?agente=' + agente + '&nagente=' + nagente + '&sector=' + sector + '&nsector=' + nsector + '&fecha=' + fecha + '');
                                                                                                                    } else {
                                                                                                                        if (tipoE == null && sector == null && alcance == null && fecha != null && agente != null && estatus != null) {
                                                                                                                            window.open(BASE_URL + 'pdfs/reportegeneral/generarReporteEventoGeneralSeleccionAgenteEstatusFecha?agente=' + agente + '&nagente=' + nagente + '&estatus=' + estatus + '&nestatus=' + nestatus + '&fecha=' + fecha + '');
                                                                                                                        } else {
                                                                                                                            //====================================================================Reportes para Alcance
                                                                                                                            if (tipoE == null && sector == null && alcance != null && fecha == null && agente == null && estatus == null) {
                                                                                                                                window.open(BASE_URL + 'pdfs/reportegeneral/generarReporteEventoGeneralSeleccionAlcance?alcance=' + alcance + '&nalcance=' + nalcance + '');
                                                                                                                            } else {

                                                                                                                                if (tipoE == null && sector != null && alcance != null && fecha == null && agente == null && estatus == null) {
                                                                                                                                    window.open(BASE_URL + 'pdfs/reportegeneral/generarReporteEventoGeneralSeleccionAlcanceSector?alcance=' + alcance + '&nalcance=' + nalcance + '&sector=' + sector + '&nsector=' + nsector + '');
                                                                                                                                } else {

                                                                                                                                    if (tipoE == null && sector == null && alcance != null && fecha == null && agente == null && estatus != null) {
                                                                                                                                        window.open(BASE_URL + 'pdfs/reportegeneral/generarReporteEventoGeneralSeleccionAlcanceEstatus?alcance=' + alcance + '&nalcance=' + nalcance + '&estatus=' + estatus + '&nestatus=' + nestatus + '');
                                                                                                                                    } else {

                                                                                                                                        if (tipoE == null && sector == null && alcance != null && fecha != null && agente == null && estatus == null) {
                                                                                                                                            window.open(BASE_URL + 'pdfs/reportegeneral/generarReporteEventoGeneralSeleccionAlcanceFecha?alcance=' + alcance + '&nalcance=' + nalcance + '&fecha=' + fecha + '');
                                                                                                                                        } else {

                                                                                                                                            if (tipoE == null && sector != null && alcance != null && fecha == null && agente == null && estatus != null) {
                                                                                                                                                window.open(BASE_URL + 'pdfs/reportegeneral/generarReporteEventoGeneralSeleccionAlcanceSectorEstatus?alcance=' + alcance + '&nalcance=' + nalcance + '&sector=' + sector + '&nsector=' + nsector + '&estatus=' + estatus + '&nestatus=' + nestatus + '');
                                                                                                                                            } else {

                                                                                                                                                if (tipoE == null && sector != null && alcance != null && fecha != null && agente == null && estatus == null) {
                                                                                                                                                    window.open(BASE_URL + 'pdfs/reportegeneral/generarReporteEventoGeneralSeleccionAlcanceSectorFecha?alcance=' + alcance + '&nalcance=' + nalcance + '&sector=' + sector + '&nsector=' + nsector + '&fecha=' + fecha + '');
                                                                                                                                                } else {

                                                                                                                                                    if (tipoE == null && sector != null && alcance != null && fecha != null && agente == null && estatus != null) {
                                                                                                                                                        window.open(BASE_URL + 'pdfs/reportegeneral/generarReporteEventoGeneralSeleccionAlcanceSectorEstatusFecha?alcance=' + alcance + '&nalcance=' + nalcance + '&sector=' + sector + '&nsector=' + nsector + '&estatus=' + estatus + '&nestatus=' + nestatus + '&fecha=' + fecha + '');
                                                                                                                                                    } else {
                                                                                                                                                        if (tipoE == null && sector == null && alcance != null && fecha != null && agente == null && estatus != null) {
                                                                                                                                                            window.open(BASE_URL + 'pdfs/reportegeneral/generarReporteEventoGeneralSeleccionAlcanceEstatusFecha?alcance=' + alcance + '&nalcance=' + nalcance + '&estatus=' + estatus + '&nestatus=' + nestatus + '&fecha=' + fecha + '');
                                                                                                                                                        } else {
//================================================================================================================================================================================REPORTES PARA SECTOR=====================================================================================================================================================================================================================================================================================================

                                                                                                                                                            if (tipoE == null && sector != null && alcance == null && fecha == null && agente == null && estatus == null) {
                                                                                                                                                                window.open(BASE_URL + 'pdfs/reportegeneral/generarReporteEventoGeneralSeleccionSector?sector=' + sector + '&nsector=' + nsector + '');
                                                                                                                                                            } else {

                                                                                                                                                                if (tipoE == null && sector != null && alcance == null && fecha == null && agente == null && estatus != null) {
                                                                                                                                                                    window.open(BASE_URL + 'pdfs/reportegeneral/generarReporteEventoGeneralSeleccionSectorEstatus?sector=' + sector + '&nsector=' + nsector + '&nestatus=' + nestatus + '&estatus=' + estatus + '');
                                                                                                                                                                } else {

                                                                                                                                                                    if (tipoE == null && sector != null && alcance == null && fecha != null && agente == null && estatus == null) {
                                                                                                                                                                        window.open(BASE_URL + 'pdfs/reportegeneral/generarReporteEventoGeneralSeleccionSectorFecha?sector=' + sector + '&nsector=' + nsector + '&fecha=' + fecha + '');
                                                                                                                                                                    } else {

                                                                                                                                                                        if (tipoE == null && sector != null && alcance == null && fecha != null && agente == null && estatus != null) {
                                                                                                                                                                            window.open(BASE_URL + 'pdfs/reportegeneral/generarReporteEventoGeneralSeleccionSectorEstatusFecha?sector=' + sector + '&nsector=' + nsector + '&nestatus=' + nestatus + '&estatus=' + estatus + '&fecha=' + fecha + '');
                                                                                                                                                                        } else {
//========================================================================================================================================================================Reportes para Estatus========================================================================================================================================================================================================================
                                                                                                                                                                            if (tipoE == null && sector == null && alcance == null && fecha == null && agente == null && estatus != null) {
                                                                                                                                                                                window.open(BASE_URL + 'pdfs/reportegeneral/generarReporteEventoGeneralSeleccionEstatus?&nestatus=' + nestatus + '&estatus=' + estatus + '');
                                                                                                                                                                            } else {

                                                                                                                                                                                if (tipoE == null && sector == null && alcance == null && fecha != null && agente == null && estatus != null) {
                                                                                                                                                                                    window.open(BASE_URL + 'pdfs/reportegeneral/generarReporteEventoGeneralSeleccionEstatusFecha?&nestatus=' + nestatus + '&estatus=' + estatus + '&fecha=' + fecha + '');
                                                                                                                                                                                } else {


                                                                                                                                                                                    //====================================================================================================================================================================Reportes para fecha seleccionada================================================================================================
                                                                                                                                                                                    if (tipoE == null && sector == null && alcance == null && fecha != null && agente == null && estatus == null) {
                                                                                                                                                                                        window.open(BASE_URL + 'pdfs/reportegeneral/generarReporteEventoGeneralSeleccionFecha?fecha=' + fecha + '');
                                                                                                                                                                                    } else {
//====================================================================================================================================================================Reportes para tipo de evento seleccionado parte 2================================================================================================
                                                                                                                                                                                    
                                                                                                                                                                                        if (tipoE != null && sector == null && alcance != null && fecha == null && agente == null && estatus != null) {
                                                                                                                                                                                            window.open(BASE_URL + 'pdfs/reportegeneral/generarReporteEventoGeneralSeleccionTipoEventoAlcanceEstatus?tipoEvento=' + tipoE + '&ntipoEvento=' + ntipoE + '&alcance=' + alcance + '&nalcance=' + nalcance + '&estatus=' + estatus + '&nestatus=' + nestatus + '');
                                                                                                                                                                                        } else {

                                                                                                                                                                                            if (tipoE != null && sector == null && alcance != null && fecha != null && agente == null && estatus == null) {
                                                                                                                                                                                                window.open(BASE_URL + 'pdfs/reportegeneral/generarReporteEventoGeneralSeleccionTipoEventoAlcanceFecha?tipoEvento=' + tipoE + '&ntipoEvento=' + ntipoE + '&alcance=' + alcance + '&nalcance=' + nalcance + '&fecha=' + fecha + '');
                                                                                                                                                                                            } else {

                                                                                                                                                                                                if (tipoE != null && sector != null && alcance != null && fecha == null && agente == null && estatus == null) {
                                                                                                                                                                                                window.open(BASE_URL + 'pdfs/reportegeneral/generarReporteEventoGeneralSeleccionTipoEventoAlcanceSector?tipoevento=' + tipoE + '&ntipoEvento=' + ntipoE + '&alcance=' + alcance + '&nalcance=' + nalcance + '&sector=' + sector + '&nsector=' + nsector + '');
                                                                                                                                                                                            } else {

                                                                                                                                                                                                if (tipoE != null && sector != null && alcance == null && fecha == null && agente == null && estatus != null) {
                                                                                                                                                                                                window.open(BASE_URL + 'pdfs/reportegeneral/generarReporteEventoGeneralSeleccionTipoEventoSectorEstatus?tipoevento=' + tipoE + '&ntipoEvento=' + ntipoE + '&estatus=' + estatus + '&nestatus=' + nestatus + '&sector=' + sector + '&nsector=' + nsector + '');
                                                                                                                                                                                            } else {

                                                                                                                                                                                                if (tipoE != null && sector != null && alcance == null && fecha != null && agente == null && estatus == null) {
                                                                                                                                                                                                window.open(BASE_URL + 'pdfs/reportegeneral/generarReporteEventoGeneralSeleccionTipoEventoSectorFecha?tipoevento=' + tipoE + '&ntipoEvento=' + ntipoE + '&fecha=' + fecha  + '&sector=' + sector + '&nsector=' + nsector + '');
                                                                                                                                                                                            } else {

                                                                                                                                                                                               if (tipoE != null && sector == null && alcance == null && fecha != null && agente == null && estatus != null) {
                                                                                                                                                                                                window.open(BASE_URL + 'pdfs/reportegeneral/generarReporteEventoGeneralSeleccionTipoEventoEstatusFecha?tipoevento=' + tipoE + '&ntipoEvento=' + ntipoE + '&fecha=' + fecha  + '&estatus=' + estatus + '&nestatus=' + nestatus + '');
                                                                                                                                                                                            } else {

                                                                                                                                                                                                 if (tipoE != null && sector == null && alcance != null && fecha == null && agente != null && estatus != null) {
                                                                                                                                                                                                window.open(BASE_URL + 'pdfs/reportegeneral/generarReporteEventoGeneralSeleccionTipoEventoAgenteAlcanceEstatus?tipoEvento=' + tipoE + '&ntipoEvento=' + ntipoE + '&agente=' + agente  +'&nagente=' + nagente  + '&alcance=' + alcance  + '&nalcance=' + nalcance  + '&estatus=' + estatus + '&nestatus=' + nestatus + '');
                                                                                                                                                                                            } else {

                                                                                                                                                                                                if (tipoE != null && sector == null && alcance != null && fecha != null && agente != null && estatus == null) {
                                                                                                                                                                                                window.open(BASE_URL + 'pdfs/reportegeneral/generarReporteEventoGeneralSeleccionTipoEventoAgenteAlcanceFecha?tipoEvento=' + tipoE + '&ntipoEvento=' + ntipoE + '&agente=' + agente  +'&nagente=' + nagente  + '&alcance=' + alcance  + '&nalcance=' + nalcance  + '&fecha=' + fecha + '');
                                                                                                                                                                                            } else {

                                                                                                                                                                                                if (tipoE != null && sector != null && alcance != null && fecha == null && agente == null && estatus != null) {
                                                                                                                                                                                                window.open(BASE_URL + 'pdfs/reportegeneral/generarReporteEventoGeneralSeleccionTipoEventoAlcanceSectorEstatus?tipoEvento=' + tipoE + '&ntipoEvento=' + ntipoE + '&sector=' + sector  +'&nsector=' + nsector  + '&alcance=' + alcance  + '&nalcance=' + nalcance  + '&estatus=' + estatus + '&nestatus=' + nestatus + '');
                                                                                                                                                                                            } else {

                                                                                                                                                                                                if (tipoE != null && sector != null && alcance != null && fecha != null && agente == null && estatus == null) {
                                                                                                                                                                                                window.open(BASE_URL + 'pdfs/reportegeneral/generarReporteEventoGeneralSeleccionTipoEventoAlcanceSectorFecha?tipoEvento=' + tipoE + '&ntipoEvento=' + ntipoE + '&sector=' + sector  +'&nsector=' + nsector  + '&alcance=' + alcance  + '&nalcance=' + nalcance  + '&fecha=' + fecha + '');
                                                                                                                                                                                            } else {

                                                                                                                                                                                              

                                                                                                                                                                                                 if (tipoE != null && sector != null && alcance != null && fecha != null && agente != null && estatus == null) {
                                                                                                                                                                                                window.open(BASE_URL + 'pdfs/reportegeneral/generarReporteEventoGeneralSeleccionTipoEventoAgenteAlcanceSectorFecha?tipoEvento=' + tipoE + '&ntipoEvento=' + ntipoE + '&sector=' + sector  +'&nsector=' + nsector  + '&fecha=' + fecha  + '&agente=' + agente + '&nagente=' + nagente +'&alcance=' + alcance + '&nalcance=' + nalcance + '');
                                                                                                                                                                                            } else {

                                                                                                                                                                                                 if (tipoE != null && sector == null && alcance != null && fecha != null && agente != null && estatus != null) {
                                                                                                                                                                                                window.open(BASE_URL + 'pdfs/reportegeneral/generarReporteEventoGeneralSeleccionTipoEventoAgenteAlcanceEstatusFecha?tipoEvento=' + tipoE + '&ntipoEvento=' + ntipoE + '&estatus=' + estatus  +'&nestatus=' + nestatus  + '&fecha=' + fecha  + '&agente=' + agente + '&nagente=' + nagente +'&alcance=' + alcance + '&nalcance=' + nalcance + '');
                                                                                                                                                                                            } else {

                                                                                                                                                                                                if (tipoE != null && sector != null && alcance == null && fecha != null && agente != null && estatus != null) {
                                                                                                                                                                                                window.open(BASE_URL + 'pdfs/reportegeneral/generarReporteEventoGeneralSeleccionTipoEventoAgenteSectorEstatusFecha?tipoEvento=' + tipoE + '&ntipoEvento=' + ntipoE + '&sector=' + sector  +'&nsector=' + nsector  + '&fecha=' + fecha  + '&agente=' + agente + '&nagente=' + nagente +'&estatus=' + estatus + '&nestatus=' + nestatus + '');
                                                                                                                                                                                            } else {

                                                                                                                                                                                                 if (tipoE != null && sector != null && alcance != null && fecha != null && agente == null && estatus != null) {
                                                                                                                                                                                                window.open(BASE_URL + 'pdfs/reportegeneral/generarReporteEventoGeneralSeleccionTipoEventoAlcanceSectorEstatusFecha?tipoEvento=' + tipoE + '&ntipoEvento=' + ntipoE + '&sector=' + sector  +'&nsector=' + nsector  + '&fecha=' + fecha  + '&estatus=' + estatus + '&nestatus=' + nestatus +'&alcance=' + alcance + '&nalcance=' + nalcance + '');
                                                                                                                                                                                            } else {

                                                                                                                                                                                               if (tipoE != null && sector != null && alcance == null && fecha != null && agente == null && estatus != null) {
                                                                                                                                                                                                window.open(BASE_URL + 'pdfs/reportegeneral/generarReporteEventoGeneralSeleccionTipoEventoSectorEstatusFecha?tipoEvento=' + tipoE + '&ntipoEvento=' + ntipoE + '&sector=' + sector  +'&nsector=' + nsector  + '&fecha=' + fecha  + '&estatus=' + estatus + '&nestatus=' + nestatus +'');
                                                                                                                                                                                            } else {

                                                                                                                                                                                                window.open(BASE_URL + 'pdfs/reportegeneral/generarReporteEventoGeneral');

                                                                                                                                                                                            }
                                                                                                                                                                                            }


                                                                                                                                                                                            }


                                                                                                                                                                                            }


                                                                                                                                                                                            }


                                                                                                                                                                                            }

                                                                                                                                                                                            }
                                                                                                                                                                                            }
                                                                                                                                                                                            }
                                                                                                                                                                                            }


                                                                                                                                                                                            }


                                                                                                                                                                                            

                                                                                                                                                                                            }


                                                                                                                                                                                            }



                                                                                                                                                                                            }



                                                                                                                                                                                        }



                                                                                                                                                                                    }

                                                                                                                                                                                }


                                                                                                                                                                            }


                                                                                                                                                                        }


                                                                                                                                                                    }


                                                                                                                                                                }

                                                                                                                                                            }


                                                                                                                                                        }

                                                                                                                                                    }


                                                                                                                                                }


                                                                                                                                            }


                                                                                                                                        }


                                                                                                                                    }


                                                                                                                                }


                                                                                                                            }


                                                                                                                        }

                                                                                                                    }
                                                                                                                }
                                                                                                            }
                                                                                                        }

                                                                                                    }

                                                                                                }

                                                                                            }
                                                                                        }
                                                                                    }
                                                                                }
                                                                            }
                                                                        }

                                                                    }

                                                                }
                                                            }

                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }

                            }
                        }
                    }
                }


            }

        }

    }
});
