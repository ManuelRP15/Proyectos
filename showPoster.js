// Muestra un modal con el póster del contenido
function showPosterDialog(primaryControl) {
    const formContext = primaryControl;

    // Obtiene la URL de la imagen y el título del registro actual
    const imageUrl = formContext.getAttribute("dtt_imageurl")?.getValue();
    const title = formContext.getAttribute("mrp_name")?.getValue() || "Movie Poster";

    // Si no hay imagen, muestra una alerta y detiene la ejecución
    if (!imageUrl) {
        return Xrm.Navigation.openAlertDialog({ text: "There's no image URL defined for this content." });
    }

    // Prepara los datos a pasar al recurso HTML
    const data = encodeURIComponent(`img=${encodeURIComponent(imageUrl)}&title=${encodeURIComponent(title)}`);

    // Define la configuración de la página a abrir
    const pageInput = {
        pageType: "webresource",
        webresourceName: "dtt_showPoster",
        data: data
    };

    // Opciones del modal (tamaño y posición)
    const navigationOptions = {
        target: 2, // 2 = modal
        width: { value: 60, unit: "%" },
        height: { value: 70, unit: "%" },
        position: 1 // centrado
    };

    // Abre la ventana modal con la imagen
    Xrm.Navigation.navigateTo(pageInput, navigationOptions);
}
