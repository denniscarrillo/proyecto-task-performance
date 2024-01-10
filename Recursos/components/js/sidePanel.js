
/* ============================ Interaccion del SidePanel para mostrar y ocultar ============================ */
export let sidePanel_Interaction = (btnIdShow, btnIdHide) => {
    //Contenedores del sidePanel
    let $sidePanelContainter = document.querySelector('.side-panel-container'); //Principal
    let $sidePanelContent = document.querySelector('.side-panel-content'); //Secundario

    $sidePanelContainter.addEventListener('click', () => {
        $sidePanelContent.setAttribute('style', 'right: -25%;');
        setTimeout(()=> {
            $sidePanelContainter.setAttribute('style', 'z-index: -10;');
        }, 200);
        })
        btnIdShow.addEventListener('click', () => {
            $sidePanelContainter.setAttribute('style', 'z-index: 10;');
            $sidePanelContent.setAttribute('style', 'right: 0;');
        });
        btnIdHide.addEventListener('click', () => {
            $sidePanelContent.setAttribute('style', 'right: -25%;');
            setTimeout(()=> {
                $sidePanelContainter.setAttribute('style', 'z-index: -10;');
            }, 200);
        });
        // =============================================================================================================
    }