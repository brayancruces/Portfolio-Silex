Portfolio Silex
===============

Open Portfolio using Silex.

Éste es un Portfolio para un Desarrollador Web Freelance o "Freelance WebDeveloper".


### Tecnologías
* Silex cómo framework PHP siguiendo la organización de archivos recomendada para todo proyecto Silex.
* Stylus como pre-procesador CSS3.
* Nib para añadir capacidades extra a Stylus.

### Silex, sus componentes
Se han utilizado los siguientes plugins:
* FormServiceProvider
* HttpCacheServiceProvider
* MonologServiceProvider
* SecurityServiceProvider
* SwiftmailerServiceProvider
* TranslationServiceProvider
* TwigServiceProvider
* UrlGeneratorServiceProvider
* ValidatorServiceProvider
* MessageDigestPasswordEncoder (Symfony)

## Instrucciones de uso
1. Descarga los componentes de Silex usando el gestor de paquetes composer, mediante el archivo raíz `composer.json`
2. En caso de utilizar DB, añade el plugin DoctrineServiceProvider en tu archivo `app.php`. Descomenta las líneas correspontientes a `*** DOCTRINE ***` y configura el plugin acorde a los ajustes de tu servidor.
