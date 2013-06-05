/* --- Objetos JSON --- */
var skills = {
        html5: 80,
        css3: 60,
        jquery: 70,
        jquerym: 30,
        mootools: 10,
        php: 80,
        symfony2: 40,
        django: 10,
        nodejs: 10,
        photoshop: 35,
        illustrator: 10
    };

$(document).on("ready", inicio);

function inicio()
{

    $("h1").on("click", mixpanelRegister);

    //----------//
    // About Me //
    //-------------------------------------------------//

    /* --- Skills --- */
    $(".skills .bar .level").each(function () {
        var skillname  = $(this).parent().parent().attr('id'),
            skillvalue = skills[skillname] + "%";
        $(this).css('width', skillvalue);
    });

}


function mixpanelRegister()
{
    // This sends us an event every time a user clicks the button
    mixpanel.track("Button clicked");
}