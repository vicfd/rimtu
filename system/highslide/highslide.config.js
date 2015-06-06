/**
*	Site-specific configuration settings for Highslide JS
*/
hs.graphicsDir = 'http://127.0.0.1/system/highslide/graphics/';
hs.showCredits = false;
hs.creditsPosition = 'bottom left';
hs.outlineType = null;
hs.dimmingOpacity = 0.2;
hs.align = 'center';
hs.allowSizeReduction = false;
hs.allowMultipleInstances = false;
hs.enableKeyListener = false;
hs.headingEval = 'this.a.title';
hs.dragByHeading = false;
hs.registerOverlay({
	html: '<div class="closebutton" onclick="return hs.close(this)" title="Cerrar"></div>',
	position: 'top right',
	useOnHtml: false,
	fade: 1 // fading the semi-transparent overlay looks bad in IE
});


// Spanish language strings
hs.lang = {
	cssDirection: 'ltr',
	loadingText: 'Cargando...',
	loadingTitle: 'Click para cancelar',
	focusTitle: 'Click para traer al frente',
	fullExpandTitle: 'Expandir al tamaño actual',
	creditsText: 'Potenciado por <i>Highslide JS</i>',
	creditsTitle: 'Ir al home de Highslide JS',
	previousText: 'Anterior',
	nextText: 'Siguiente',
	moveText: 'Mover',
	closeText: 'Cerrar',
	closeTitle: 'Cerrar (esc)',
	resizeTitle: 'Redimensionar',
	playText: 'Iniciar',
	playTitle: 'Iniciar slideshow (barra espacio)',
	pauseText: 'Pausar',
	pauseTitle: 'Pausar slideshow (barra espacio)',
	previousTitle: 'Anterior (flecha izquierda)',
	nextTitle: 'Siguiente (flecha derecha)',
	moveTitle: 'Mover',
	fullExpandText: 'Tamaño real',
	number: 'Imagen %1 de %2',
	restoreTitle: 'Click para cerrar la imagen, click y arrastrar para mover. Usa las flechas del teclado para avanzar o retroceder.'
};
