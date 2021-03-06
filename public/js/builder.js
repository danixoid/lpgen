/* SETTINGS */

var pageContainer = "#page"; //typically no need to change this
var enablePreview = true; //set to off to disable previews

var theBody;
var editableItems = new Array();

editableItems['.frameCover'] = [];
editableItems['nav#main-navbar'] = ['background-color', 'box-shadow'];
editableItems['nav a'] = ['font-weight', 'font-size', 'text-transform'];
editableItems['nav a.btn-nav'] = ['font-weight', 'font-size', 'background-color'];
editableItems['.nav-callus'] = ['color', 'font-weight','font-size', 'text-transform'];
editableItems['a.edit'] = ['color','font-weight', 'font-size', 'text-transform'];
editableItems['.text-edit'] = ['color', 'font-weight','font-size', 'text-transform', 'background-color'];
editableItems['img'] = ['border-top-left-radius', 'border-top-right-radius', 'border-bottom-left-radius', 'border-bottom-right-radius', 'border-color', 'border-style', 'border-width'];
editableItems['.bg-img'] = ['background-color'];
editableItems['h1'] = ['color', 'font-size', 'background-color', 'font-family', 'font-weight'];
editableItems['h2'] = ['color', 'font-size', 'background-color', 'font-family', 'font-weight'];
editableItems['h3'] = ['color', 'font-size', 'background-color', 'font-family', 'font-weight'];
editableItems['h4'] = ['color', 'font-size', 'background-color', 'font-family', 'font-weight'];
editableItems['h5'] = ['color', 'font-size', 'background-color', 'font-family', 'font-weight'];
editableItems['h6'] = ['color', 'font-size', 'background-color', 'font-family', 'font-weight'];
editableItems['p'] = ['color', 'font-size', 'background-color', 'font-family', 'font-weight'];
editableItems['a.btn, button.btn, .btn'] = ['border-radius', 'font-size', 'background-color', 'box-shadow', 'border-color', 'border-style', 'border-width'];
editableItems['.bg-edit'] = ['background-color'];
editableItems['.block-edit'] = ['background-image'];
editableItems['i, span.fa'] = ['color', 'font-size'];


var editableItemOptions = new Array();

editableItemOptions['nav a : font-weight'] = ['700','300','400','900'];
editableItemOptions['nav a.btn-nav : font-weight'] = ['700','300','400','900'];
editableItemOptions['img : border-style'] = ['none', 'dotted', 'dashed', 'solid'];
editableItemOptions['img : border-width'] = ['1px', '2px', '3px', '4px'];
editableItemOptions['h1 : font-family'] = ['default', 'Arsenal', 'Helvetica', 'Arial', 'Times New Roman'];
editableItemOptions['h2 : font-family'] = ['default', 'Arsenal', 'Helvetica', 'Arial', 'Times New Roman'];
editableItemOptions['h3 : font-family'] = ['default', 'Arsenal', 'Helvetica', 'Arial', 'Times New Roman'];
editableItemOptions['h4 : font-family'] = ['default', 'Arsenal', 'Helvetica', 'Arial', 'Times New Roman'];
editableItemOptions['h5 : font-family'] = ['default', 'Arsenal', 'Helvetica', 'Arial', 'Times New Roman'];
editableItemOptions['h6 : font-family'] = ['default', 'Arsenal', 'Helvetica', 'Arial', 'Times New Roman'];
editableItemOptions['p : font-family'] = ['default', 'Arsenal', 'Helvetica', 'Arial', 'Times New Roman'];

var editableContent = ['.editContent', '.navbar a', 'a.edit', 'h1:not(.no-edit)', 'h2:not(.no-edit)', 'h3:not(.no-edit)', 'h4:not(.no-edit)', 'h5:not(.no-edit)', 'h6:not(.no-edit)', 'p:not(.no-edit)', '.nav-callus', '.text-edit', '.btn:not(.no-edit)', '.footer a:not(.fa)', '.tableWrapper'];


/* FLAT UI PRO INITS */

$(function () {

    // Tabs
    $(".nav-tabs a").on('click', function (e) {
        e.preventDefault();
        $(this).tab("show");
    });

});


/* END SETTINGS */

var mainMenuWidth = 230;
var secondMenuWidth = 300;


$(window).load(function () {

    $('#loader').fadeOut(function () {

        $('#menu').animate({'left': '-190px'}, 1000);

    });


    //activate previews?
    if (enablePreview == true) {

        $('#preview').show();

    }

    loadPagesByDomain($("#selectDomain").val());

    // $("#selectDomain").on('change',function(ev){;
    //     loadPagesByDomain($("#selectDomain").val());
    // });

    $('#viewSite').attr('href','http://' + $("#selectAlias option:selected").text());

    $("#selectAlias").on('change',function(ev){
        $('#viewSite').attr('href','http://' + $("#selectAlias option:selected").text());
    });

    $('#preview').on('click',function() {
        window.open('/builder/preview/' + $('#selectDomain').val() + '/'
            + $('#pageTitle span span').text(),'_blank');
    });

    $('#exportPage').on('click',function(ev) {

        if(confirm('Все страницы будут опубликованы для всех поддоменов и алиасов. Уверены?')) {
            $.ajax({
                url: '/builder/publish',
                data: JSON.stringify({
                    'domain_id': $('#selectDomain').val(),
                    'alias_id': $('#selectAlias').val()
                }),
                type: 'POST',
                // dataType: 'json',
            }).done(function (response) {
                $('#savePage span.bLabel').html($('#savePage span.bLabel').html() + '/Опубликовано');
            }).error(function (response) {
                alert('Ошибка публикации. Попробуйте еще раз. Или обратитесь к администратору.');
            });
        }
    });

    $('#auth').submit(function(ev){
        var form = $(this);
        ev.preventDefault();

        $.get('/_token',function(token) {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': token._token
                }
            });

            $.ajax({
                url : form.attr('action'),
                data : form.serialize(),
                dataType: 'json',
                type: 'POST',
            }).done(function (response) {
                $('#auth .modal').modal('hide');
                savePage(ev);
            }).error(function (response) {
                var mess = '';

                console.log(response.responseText);
                $.each(JSON.parse(response.responseText), function(index, value) {
                    mess += value + "\n";
                });

                alert(mess);
            });
        });

    });

});

function loadPagesByDomain(domain_id) {

    var form = $('#getBlocksForm');
    var formAction = form.attr('action');
    var formMethod = form.attr('method');

    $('#domainHidden').val(domain_id);

    $.ajax({
        url: formAction + '?domain_id=' + domain_id,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        type: formMethod,
    }).done(function (pages) {

        $('#pageList ul#page1').empty();

        $('#pageList ul.generate-ul').remove();
        $('ul#pages li.generate-li').remove();

        var framesForLater = [];

        for (x = 0; x < pages.length; x++) {

            //does the parent UL exist?

            var xx = x + 1;

            if ($('ul#page' + xx).size() == 0) {

                var newUL = $('<ul id="page' + xx + '" class="generate-ul"></ul>');

                $('#pageList').append(newUL);

                makeSortable(newUL);

                var newItem = $('<option value="/' + pages[x].name + '">' + pages[x].name + '</option>')

                $('#internalLinksDropdown').append(newItem);
            }


            for (var y = 0; y < pages[x].l_blocks.length; y++) {

                $('#start').hide();

                if (pages[x].l_blocks[y] != null) {

                    //build 'em

                    var toInsert = $("<li>" + pages[x].l_blocks[y].frame + "</li>");

                    toInsert.find('iframe').attr('id', 'ui-id-' + x + y);
                    toInsert.find('.frameCover').show();
                    toInsert.find('.frameCover').css('height','100%');;

                    //sandbox? if so, create the sanboxed frame
                    var attr = toInsert.find('iframe').attr('data-sandbox');

                    if (typeof attr !== typeof undefined && attr !== false) {

                        var theiFrame = toInsert.find('iframe');

                        var theID = theiFrame.attr('data-sandbox');

                        var sandboxedFrame = $('<iframe src="' + theiFrame.attr('src') + '" id="' + theID + '" sandbox="allow-same-origin"></iframe>');

                        $('#sandboxes').append(sandboxedFrame);

                    }


                    framesForLater[toInsert.find('iframe').attr('id')] = pages[x].l_blocks[y].element;

                    toInsert.find('iframe').load(function () {

                        $(this).contents().find(pageContainer).html(framesForLater[$(this).attr('id')]);

                        //sandbox

                        var attr = $(this).attr('data-sandbox');

                        if (typeof attr !== typeof undefined && attr !== false) {

                            $('iframe#' + $(this).attr('data-sandbox')).contents().find(pageContainer).html(framesForLater[$(this).attr('id')]);

                            var theLoaderFunction = $(this).data('data-loaderfunction');

                            theiFrame = $(this);

                            var codeToExecute = "theiFrame[0].contentWindow." + theiFrame.attr('data-loaderfunction') + "()";
                            var tmpFunc = new Function(codeToExecute);
                            tmpFunc();

                        }

                    });

                    $('ul#page' + xx).append(toInsert);

                    //page links
                }
            }

            if (xx > 1 && typeof pages[x].name != "undefined") {

                var newLI = $('<li class="generate-li"><a class="plink" href="#page' + xx + '">'
                    + pages[x].name + '</a><span class="pageButtons"><a class="fileEdit" href="">'
                    + '<span class="fui-new"></span></a><a class="fileDel" href="">'
                    + '<span class="fui-cross"></span></a><a href="#" class="btn btn-xs btn-primary btn-embossed fileSave">'
                    + '<span class="fui-check"></span></a></span></li>');

                $('ul#pages').append(newLI);

            }

        }

        allEmpty();
    });
}



var hexDigits = ["0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "a", "b", "c", "d", "e", "f"];

//Function to convert hex format to a rgb color
function rgb2hex(rgb) {
    rgb = rgb.match(/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/);
    return "#" + hex(rgb[1]) + hex(rgb[2]) + hex(rgb[3]);
}

function hex(x) {
    return isNaN(x) ? "00" : hexDigits[(x - x % 16) / 16] + hexDigits[x % 16];
}

function getRandomArbitrary(min, max) {
    return Math.floor(Math.random() * (max - min) + min);
}

var pendingChanges = false;

function setPendingChanges(v) {

    if (v == true) {

        $(window).bind('beforeunload', function(){
            return '>>>>>Before You Go<<<<<<<< \n Your custom message go here';
        });

        $('#savePage .bLabel').text("Сохранить изменения (!)");

        pendingChanges = true;

    } else {

        $(window).unbind('beforeunload');

        $('#savePage .bLabel').text("Сохранено");

        pendingChanges = false;

    }

}

function pageEmpty() {

    if ($('#pageList ul:visible > li').size() == 0) {

        $('#start').show();

        $('#frameWrapper').addClass('empty');

    } else {

        $('#start').hide();

        $('#frameWrapper').removeClass('empty');

    }

}

//ar1 ar3
//var emptyMarker = true;


function allEmpty() {

    var allEmpty = false;

    if ($('#pageList li').size() == 0) {

        allEmpty = true;

    } else {

        allEmpty = false;

    }
    //ar1 ar3
    // emptyMarker = allEmpty;


    if (allEmpty) {

        $('a.actionButtons').each(function () {

            $(this).addClass('disabled');

        });

        $('header .modes input').each(function () {

            $(this).prop('disabled', true).parent().addClass('disabled');

        });

    } else {

        $('header .modes input').each(function () {

            $(this).prop('disabled', false).parent().removeClass('disabled');

        });

        $('a.actionButtons').each(function () {

            $(this).removeClass('disabled');

        });

    }

}


function makeDraggable(theID) {

    $('#second #elements li').each(function () {

        $(this).draggable({
            helper: function () {
                return $('<div style="height: 100px; width: 300px; background: #F9FAFA; box-shadow: 5px 5px 1px rgba(0,0,0,0.1); text-align: center; line-height: 100px; font-size: 28px; color: #16A085"><span class="fui-list"></span></div>');
            },
            revert: 'invalid',
            appendTo: 'body',
            connectToSortable: theID,
            stop: function () {

                pageEmpty();

                allEmpty();

            },
            start: function () {

                //switch to block mode
                $('input:radio[name=mode]').parent().addClass('disabled');
                $('input:radio[name=mode]#modeBlock').radio('check');

                //show all iframe covers and activate designMode

                $('#pageList ul .zoomer-wrapper .zoomer-cover').each(function () {

                    $(this).show();

                });

                //deactivate designmode

                $('#pageList ul li iframe').each(function () {

                    this.contentDocument.designMode = "off";

                });

            }
        });

    });

    $('#elements li a').each(function () {

        $(this).unbind('click').bind('click', function (e) {

            e.preventDefault();

        });

    });

}

var frameContents = '';//holds frame contents

function makeSortable(el) {

    el.sortable({
        revert: true,
        placeholder: "drop-hover",
        handle: ".frameCover",
        beforeStop: function (event, ui) {

            var theHeight;
            var attr;
            var loaderFunction_;
            var theID;
            var sandboxedFrame;

            if (ui.item.find('.frameCover').size() == 0) {

                if (ui.item.find('iframe').size() > 0) {//iframe thumbnails

                    theHeight = ui.item.height();

                    attr = ui.item.find('iframe').attr('data-sandbox');

                    if (typeof attr !== typeof undefined && attr !== false) {

                        //sandboxed

                        theID = getRandomArbitrary(10000, 1000000000);

                        sandboxedFrame = $('<iframe src="' + ui.item.find('iframe').attr('src') + '" id="' + theID + '" sandbox="allow-same-origin"></iframe>');

                        $('#sandboxes').append(sandboxedFrame);

                        if (typeof ui.item.find('iframe').attr('data-loaderfunction') !== typeof undefined && ui.item.find('iframe').attr('data-loaderfunction') !== false) {
                            loaderFunction_ = 'data-loaderfunction="' + ui.item.find('iframe').attr('data-loaderfunction') + '"';
                        }

                        ui.item.html('<iframe src="' + ui.item.find('iframe').attr('src') + '" scrolling="no" frameborder="0" data-sandbox="' + theID + '" ' + loaderFunction_ + '><iframe>');

                    } else {

                        ui.item.html('<iframe src="' + ui.item.find('iframe').attr('src') + '" scrolling="no" frameborder="0"><iframe>');

                    }

                    ui.item.find('iframe').uniqueId();
                    ui.item.find('iframe').height(theHeight + "px");


                } else {//image thumbnails

                    theHeight = ui.item.find('img').attr('data-height');

                    //is this iframe to be sandboxed?

                    attr = ui.item.find('img').attr('data-sandbox');

                    if (typeof attr !== typeof undefined && attr !== false) {

                        //sandboxed

                        theID = getRandomArbitrary(10000, 1000000000);

                        sandboxedFrame = $('<iframe src="' + ui.item.find('img').attr('data-srcc') + '" id="' + theID + '" sandbox="allow-same-origin"></iframe>');

                        $('#sandboxes').append(sandboxedFrame);

                        if (typeof ui.item.find('img').attr('data-loaderfunction') !== typeof undefined && ui.item.find('img').attr('data-loaderfunction') !== false) {
                            loaderFunction_ = 'data-loaderfunction="' + ui.item.find('img').attr('data-loaderfunction') + '"';
                        }

                        ui.item.html('<iframe src="' + ui.item.find('img').attr('data-srcc') + '" scrolling="no" frameborder="0" data-sandbox="' + theID + '" ' + loaderFunction_ + '><iframe>');

                    } else {

                        ui.item.html('<iframe src="' + ui.item.find('img').attr('data-srcc') + '" scrolling="no" frameborder="0"><iframe>');

                    }

                    ui.item.find('iframe').uniqueId();
                    ui.item.find('iframe').height(theHeight + "px");
                    ui.item.find('iframe').css('background', '#ffffff url(images/loading.gif) 50% 50% no-repeat');

                    ui.item.find('iframe').load(function () {

                        heightAdjustment(ui.item.find('iframe').attr('id'), true);

                    });

                }

                //add a delete button
                var delButton = $('<button type="button" class="btn btn-danger deleteBlock"><span class="fui-trash"></span> Удалить</button>');
                var resetButton = $('<button type="button" class="btn btn-warning resetBlock"><i class="fa fa-refresh"></i> Сброс</button>');
                var htmlButton = $('<button type="button" class="btn btn-inverse htmlBlock"><i class="fa fa-code"></i> Код</button>');

                var frameCover = $('<div class="frameCover"></div>');

                frameCover.append(delButton);
                frameCover.append(resetButton);
                frameCover.append(htmlButton);

                ui.item.append(frameCover);

            } else {

                //sorted

                ui.item.find('iframe').load(function () {

                    $(this).contents().find(pageContainer).html(frameContents)

                });

            }

            setPendingChanges(true)

        },
        stop: function () {

            $('#pageList ul:visible li').each(function () {

                $(this).find('.zoomer-cover > a').remove();

            });

        },
        start: function (event, ui) {

            if (ui.item.find('.frameCover').size() != 0) {

                frameContents = ui.item.find('iframe').contents().find(pageContainer).html();

            }

        },
        over: function () {

            $('#start').hide();

        }
    });

}


function buildeStyleElements(el, theSelector) {

    for (var x = 0; x < editableItems[theSelector].length; x++) {

        //create style elements

        //alert( $(el).get(0).tagName )

        var newStyleEl = $('#styleElTemplate').clone();

        newStyleEl.attr('id', '');
        newStyleEl.find('.control-label').text(editableItems[theSelector][x] + ":");

        if (theSelector + " : " + editableItems[theSelector][x] in editableItemOptions) {//we've got a dropdown instead of open text input

            //alert( theSelector+" "+editableItems[kkey][x] )

            newStyleEl.find('input').remove();

            var newDropDown = $('<select></select>');
            newDropDown.attr('name', editableItems[theSelector][x]);

            for (z = 0; z < editableItemOptions[ theSelector + " : " + editableItems[theSelector][x] ].length; z++) {

                var newOption = $('<option value="' + editableItemOptions[theSelector + " : " + editableItems[theSelector][x]][z] + '">' + editableItemOptions[theSelector + " : " + editableItems[theSelector][x]][z] + '</option>');


                if (editableItemOptions[theSelector + " : " + editableItems[theSelector][x]][z] == $(el).css(editableItems[theSelector][x])) {

                    //current value, marked as selected
                    newOption.attr('selected', 'true')

                }


                newDropDown.append(newOption)

            }

            newStyleEl.append(newDropDown);

            newDropDown.selectpicker({style: 'btn-sm btn-default', menuStyle: 'dropdown-inverse'});


        } else {

            newStyleEl.find('input').val($(el).css(editableItems[theSelector][x])).attr('name', editableItems[theSelector][x])

            if (editableItems[theSelector][x].indexOf("color") > -1) {

                //alert( editableItems[theSelector][x]+" : "+$(el).css( editableItems[theSelector][x] ) )

                if ($(el).css(editableItems[theSelector][x]) != 'transparent' && $(el).css(editableItems[theSelector][x]) != 'none' && $(el).css(editableItems[theSelector][x]) != '') {

                    newStyleEl.val($(el).css(editableItems[theSelector][x]))

                }

                newStyleEl.find('input').spectrum({
                    preferredFormat: "hex",
                    showPalette: true,
                    allowEmpty: true,
                    showInput: true,
                    palette: [
                        ["#000", "#444", "#666", "#999", "#ccc", "#eee", "#f3f3f3", "#fff"],
                        ["#f00", "#f90", "#ff0", "#0f0", "#0ff", "#00f", "#90f", "#f0f"],
                        ["#f4cccc", "#fce5cd", "#fff2cc", "#d9ead3", "#d0e0e3", "#cfe2f3", "#d9d2e9", "#ead1dc"],
                        ["#ea9999", "#f9cb9c", "#ffe599", "#b6d7a8", "#a2c4c9", "#9fc5e8", "#b4a7d6", "#d5a6bd"],
                        ["#e06666", "#f6b26b", "#ffd966", "#93c47d", "#76a5af", "#6fa8dc", "#8e7cc3", "#c27ba0"],
                        ["#c00", "#e69138", "#f1c232", "#6aa84f", "#45818e", "#3d85c6", "#674ea7", "#a64d79"],
                        ["#900", "#b45f06", "#bf9000", "#38761d", "#134f5c", "#0b5394", "#351c75", "#741b47"],
                        ["#600", "#783f04", "#7f6000", "#274e13", "#0c343d", "#073763", "#20124d", "#4c1130"]
                    ]
                });

            }

        }



        newStyleEl.css('display', 'block');


        $('#styleElements').append(newStyleEl);


        $('#styleEditor form#stylingForm').height('auto')

    }

}

function getParentFrameID(el) {

    var theID = '';

    $('#pageList li:visible iframe').each(function () {

        theBody = $(this).contents().find('body');

        if ($.contains(document.getElementById($(this).attr('id')).contentWindow.document, el)) {

            theID = $(this).attr('id');

        }

    });

    if (theID != '') {

        return theID;

    }

}


function heightAdjustment(el, par) {

    var theFrame;
    var frameID = el;

    par = typeof par !== 'undefined' ? par : false;

    if (par == false) {


        $('#pageList li:visible iframe').each(function () {

            theBody = $(this).contents().find('body');

            if ($.contains(document.getElementById($(this).attr('id')).contentWindow.document, el)) {

                frameID = $(this).attr('id');

            }

        });

    }

    theFrame = document.getElementById(frameID);


    //realHeight = theFrame.contentWindow.document.body.offsetHeight;

    var realHeight = theFrame.contentWindow.document.body.offsetHeight;

    //alert(theFrame.contentWindow.document.body.offsetHeight)

    if(realHeight > 0) {
        $(theFrame).height(realHeight + "px");
        $(theFrame).parent().height((realHeight) + "px");
        $(theFrame).next().height((realHeight) + "px");
        //$(theFrame).parent().parent().height( (realHeight)+"px" );
    }

}

function hasSandbox(el) {

    var attr = $('#' + getParentFrameID(el.get(0))).attr('data-sandbox');

    if (typeof attr !== typeof undefined && attr !== false) {

        return attr;

    } else {

        return false;

    }

}


var _oldIcon = [];


function styleClick(el) {

    var theSelector = $(el).attr('data-selector');

    $('#editingElement').text(theSelector);


    //activate first tab
    $('#detailTabs a:first').click();


    //hide all by default
    $('a#link_Link').parent().hide();
    $('a#img_Link').parent().hide();
    $('a#icon_Link').parent().hide();
    $('a#video_Link').parent().hide();


    //is the element an ancor tag?
    if ($(el).prop('tagName') == 'A' || $(el).parent().prop('tagName') == 'A') {

        var theHref;

        $('a#link_Link').parent().show();

        if ($(el).prop('tagName') == 'A') {

            theHref = $(el).attr('href');

        } else if ($(el).parent().prop('tagName') == 'A') {

            theHref = $(el).parent().attr('href');

        }

        var zIndex = 0;

        var pageLink = false;

        //the actual select

        $('select#internalLinksDropdown').prop('selectedIndex', 0);

        $('select#internalLinksDropdown option').each(function () {

            if ($(this).attr('value') == theHref) {

                $(this).attr('selected', true);

                zIndex = $(this).index();

                pageLink = true;

            }

        });


        //the pretty dropdown
        $('.link_Tab .btn-group.select .dropdown-menu li').removeClass('selected');

        $('.link_Tab .btn-group.select .dropdown-menu li:eq(' + zIndex + ')').addClass('selected');

        $('.link_Tab .btn-group.select:eq(0) .filter-option').text($('select#internalLinksDropdown option:selected').text())

        $('.link_Tab .btn-group.select:eq(1) .filter-option').text($('select#pageLinksDropdown option:selected').text())

        if (pageLink == true) {

            $('input#internalLinksCustom').val('');

        } else {

            if ($(el).prop('tagName') == 'A') {

                if ($(el).attr('href')[0] != '#') {
                    $('input#internalLinksCustom').val($(el).attr('href'))
                } else {
                    $('input#internalLinksCustom').val('')
                }

            } else if ($(el).parent().prop('tagName') == 'A') {

                if ($(el).parent().attr('href')[0] != '#') {
                    $('input#internalLinksCustom').val($(el).parent().attr('href'))
                } else {
                    $('input#internalLinksCustom').val('')
                }

            }
        }


        //list available blocks on this page, remove old ones first

        $('select#pageLinksDropdown option:not(:first)').remove();


        $('#pageList ul:visible iframe').each(function () {

            if ($(this).contents().find(pageContainer + " > *:first").attr('id') != undefined) {

                if ($(el).attr('href') == '#' + $(this).contents().find(pageContainer + " > *:first").attr('id')) {

                    newOption = '<option selected value=#' + $(this).contents().find(pageContainer + " > *:first").attr('id') + '>#' + $(this).contents().find(pageContainer + " > *:first").attr('id') + '</option>';

                } else {

                    newOption = '<option value=#' + $(this).contents().find(pageContainer + " > *:first").attr('id') + '>#' + $(this).contents().find(pageContainer + " > *:first").attr('id') + '</option>';

                }



                $('select#pageLinksDropdown').append(newOption);

            }

        });


    }

    if ($(el).attr('data-type') == 'video') {

        $('a#video_Link').parent().show();

        $('a#video_Link').click();

        //inject current video ID,check if we're dealing with Youtube or Vimeo

        if ($(el).prev().attr('src').indexOf("vimeo.com") > -1) {//vimeo

            match = $(el).prev().attr('src').match(/player\.vimeo\.com\/video\/([0-9]*)/);

            //console.log(match);

            $('#video_Tab input#vimeoID').val(match[match.length - 1]);
            $('#video_Tab input#youtubeID').val('');

        } else {//youtube

            //temp = $(el).prev().attr('src').split('/');

            var regExp = /.*(?:youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=)([^#\&\?]*).*/;
            var match = $(el).prev().attr('src').match(regExp);

            $('#video_Tab input#youtubeID').val(match[1]);
            $('#video_Tab input#vimeoID').val('');

        }



        //alert( $(el).prev().attr('src') )


    }

    if ($(el).prop('tagName') == 'IMG') {

        $('a#img_Link').parent().show();

        //reset the file upload
        $('.imageFileTab').find('a.fileinput-exists').click();

        var srcImg = $(el).attr('src');
        var imgPreview = $('<img src="' + srcImg + '" />');

        //set the current SRC
        $('.imageFileTab').find('.fileinput-preview').append(imgPreview);
        $('.imageFileTab').find('input#imageURL').val($(el).attr('src'));

    }

    if ($(el).hasClass('bg-img')) {

        //reset the file upload
        $('.imageFileTab').find('a.fileinput-exists').click();

        var srcImg = $(el).css('background-image').match(/https?:\/\/[^\"]+/gi)[0];
        var imgPreview = $('<img src="' + srcImg + '"/>');
        $('a#img_Link').parent().show();
        $('.imageFileTab').find('input#imageURL').val(srcImg);
        $('.imageFileTab').find('.fileinput-preview ').append(imgPreview);
    }

    if ($(el).hasClass('fa')) {

        $('a#icon_Link').parent().show();

        //get icon class name, starting with fa-
        var get = $.grep(el.className.split(" "), function (v, i) {

            return v.indexOf('fa-') === 0;

        }).join();

        $('select#icons option').each(function () {

            if ($(this).val() == get) {

                $(this).attr('selected', true);

                $('#icons').trigger('chosen:updated');

            }

        });

    }


    //$(el).addClass('builder_active');

    //remove borders from other elements
    $('#pageList ul:visible li iframe').each(function () {

        //remove borders

        for (var key in editableItems) {

            $(this).contents().find(pageContainer + ' ' + key).css({'outline': 'none', 'cursor': 'default'});

            $(this).contents().find(pageContainer + ' ' + key).hover(function (e) {

                e.stopPropagation();

                if ($(this).closest('body').width() != $(this).width()) {

                    $(this).css({'outline': '3px dashed red', 'cursor': 'pointer'});

                } else {

                    $(this).css({'outline': '3px dashed red', 'outline-offset': '-3px', 'cursor': 'pointer'});

                }

            }, function () {

                if ($(this).closest('body').width() != ($(this).width() + 6)) {

                    $(this).css({'outline': '', 'cursor': ''});

                } else {

                    $(this).css({'border': '', 'cursor': '', 'outline-offset': ''});

                }

            });

        }

    });

    //unbind event
    $(el).unbind('mouseenter mouseleave');

    if ($(el).closest('body').width() != $(el).width()) {

        $(el).css({'outline': '3px dashed red', 'cursor': 'pointer'});

    } else {

        $(el).css({'outline': '3px dashed red', 'outline-offset': '-3px', 'cursor': 'pointer'});

    }



    //remove all style attributes

    $('#styleElements > *:not(#styleElTemplate)').each(function () {

        $(this).remove();

    });


    //load the attributes

    buildeStyleElements(el, theSelector)


    //show style editor if hidden

    if ($('#styleEditor').css('left') == '-300px') {

        $('#styleEditor').animate({'left': '0px'}, 250);

    }


    //save button
    $('button#saveStyling').unbind('click').bind('click', function () {

        var sandboxID;
        var elementID;

        $('#styleEditor #tab1 .form-group:not(#styleElTemplate) input, #styleEditor #tab1 .form-group:not(#styleElTemplate) select').each(function () {

            //alert( $(this).attr('name')+":"+$(this).val() )

            $(el).css($(this).attr('name'), $(this).val());

            /* SANDBOX */

            sandboxID = hasSandbox($(el))

            if (sandboxID) {

                elementID = $(el).attr('id');

                $('#' + sandboxID).contents().find('#' + elementID).css($(this).attr('name'), $(this).val())

            }

            /* END SANDBOX */

        });


        //links
        if ($(el).prop('tagName') == 'A') {

            //change the href prop?

            if ($('select#internalLinksDropdown').val() != '#') {

                $(el).attr('href', $('select#internalLinksDropdown').val());

            } else if ($('select#pageLinksDropdown').val() != '#') {

                $(el).attr('href', $('select#pageLinksDropdown').val());

            } else if ($('input#internalLinksCustom').val() != '') {

                $(el).attr('href', $('input#internalLinksCustom').val());

            }

            /* SANDBOX */

            sandboxID = hasSandbox($(el))

            if (sandboxID) {

                elementID = $(el).attr('id');

                if ($('select#internalLinksDropdown').val() != '#') {

                    $('#' + sandboxID).contents().find('#' + elementID).attr('href', $('select#internalLinksDropdown').val());

                } else if ($('select#pageLinksDropdown').val() != '#') {

                    $('#' + sandboxID).contents().find('#' + elementID).attr('href', $('select#pageLinksDropdown').val());

                } else if ($('input#internalLinksCustom').val() != '') {

                    $('#' + sandboxID).contents().find('#' + elementID).attr('href', $('input#internalLinksCustom').val());

                }

            }

            /* END SANDBOX */

        }

        if ($(el).parent().prop('tagName') == 'A') {

            //change the href prop?

            if ($('select#internalLinksDropdown').val() != '#') {

                $(el).parent().attr('href', $('select#internalLinksDropdown').val());

            } else if ($('select#pageLinksDropdown').val() != '#') {

                $(el).parent().attr('href', $('select#pageLinksDropdown').val());

            } else if ($('input#internalLinksCustom').val() != '') {

                $(el).parent().attr('href', $('input#internalLinksCustom').val());

            }

            /* SANDBOX */

            sandboxID = hasSandbox($(el))

            if (sandboxID) {

                elementID = $(el).attr('id');

                if ($('select#internalLinksDropdown').val() != '#') {

                    $('#' + sandboxID).contents().find('#' + elementID).parent().attr('href', $('select#internalLinksDropdown').val());

                } else if ($('select#pageLinksDropdown').val() != '#') {

                    $('#' + sandboxID).contents().find('#' + elementID).parent().attr('href', $('select#pageLinksDropdown').val());

                } else if ($('input#internalLinksCustom').val() != '') {

                    $('#' + sandboxID).contents().find('#' + elementID).parent().attr('href', $('input#internalLinksCustom').val());

                }

            }

            /* END SANDBOX */

        }


        //do we need to upload an image?
        if ($('a#img_Link').css('display') == 'block' && $('input#imageFileField').val() != '') {

            var form = $('form#imageUploadForm');

            var formdata = false;

            if (window.FormData) {
                formdata = new FormData(form[0]);
            }

            var formAction = form.attr('action');

            $.ajax({
                url: formAction,
                data: formdata ? formdata : form.serialize(),
                cache: false,
                contentType: false,
                processData: false,
                dataType: "json",
                type: 'POST',
            }).done(function (response,status) {

                if (status == 401) {
                    $('#auth.modal').modal('show');
                } else {
                    if (response.code == 1) {//success

                        //set the current SRC
                        $('.imageFileTab').find('.fileinput-preview').append(imgPreview);
                        $('.imageFileTab').find('input#imageURL').val(response.response);

                        //$(el).attr('src', response.response);

                        if ($(el).hasClass('bg-img')){

                            var imgPreview = $('<img src="' + response.response + '" />');

                            var bgImgUrl = "url('"+response.response+"')";
                            $(el).css('background-image', bgImgUrl );
                            $(el).css('-webkit-background-size', 'cover');
                            $(el).css('-moz-background-size', 'cover');
                            $(el).css('background-size', 'cover');
                            $(el).css('background-repeat', 'no-repeat');
                            $(el).css('background-position', 'center center');
                            $(el).css('background-attachment', 'scroll');
                        }else{
                            $(el).attr('src', response.response);
                        }

                        //reset the file upload
                        $('.imageFileTab').find('a.fileinput-exists').click();

                        /* SANDBOX */

                        sandboxID = hasSandbox($(el));

                        if (sandboxID) {

                            elementID = $(el).attr('id');

                            $('#' + sandboxID).contents().find('#' + elementID).attr('src', response.response);

                        }

                        /* END SANDBOX */



                    } else if (response.code == 0) {//error

                        alert('Something went wrong: ' + response.response)

                    }
                }

            });


        } else if ($('a#img_Link').css('display') == 'block') {


            //no image to upload, just a SRC change
            if ($('input#imageURL').val() != '' && $('input#imageURL').val() != $(el).attr('src')) {

                $(el).attr('src', $('input#imageURL').val());

                /* SANDBOX */

                sandboxID = hasSandbox($(el))

                if (sandboxID) {

                    elementID = $(el).attr('id');

                    $('#' + sandboxID).contents().find('#' + elementID).attr('src', $('input#imageURL').val());

                }

                /* END SANDBOX */

            }


        }


        //icons

        if ($(el).hasClass('fa')) {

            //out with the old, in with the new :)
            //get icon class name, starting with fa-
            var get = $.grep(el.className.split(" "), function (v, i) {

                return v.indexOf('fa-') === 0;

            }).join();

            //if the icons is being changed, save the old one so we can reset it if needed

            if (get != $('select#icons').val()) {

                $(el).uniqueId();

                _oldIcon[$(el).attr('id')] = get;

                //alert( _oldIcon[$(el).attr('id')] )

            }

            $(el).removeClass(get).addClass($('select#icons').val());


            /* SANDBOX */

            sandboxID = hasSandbox($(el))

            if (sandboxID) {

                elementID = $(el).attr('id');

                $('#' + sandboxID).contents().find('#' + elementID).removeClass(get).addClass($('select#icons').val());

            }

            /* END SANDBOX */

        }


        //video URL

        if ($(el).attr('data-type') == 'video') {

            if ($('input#youtubeID').val() != '') {

                $(el).prev().attr('src', "//www.youtube.com/embed/" + $('#video_Tab input#youtubeID').val());

            } else if ($('input#vimeoID').val() != '') {

                $(el).prev().attr('src', "//player.vimeo.com/video/" + $('#video_Tab input#vimeoID').val() + "?title=0&amp;byline=0&amp;portrait=0");

            }


            /* SANDBOX */

            sandboxID = hasSandbox($(el))

            if (sandboxID) {

                elementID = $(el).attr('id');

                if ($('input#youtubeID').val() != '') {

                    $('#' + sandboxID).contents().find('#' + elementID).prev().attr('src', "//www.youtube.com/embed/" + $('#video_Tab input#youtubeID').val());

                } else if ($('input#vimeoID').val() != '') {

                    $('#' + sandboxID).contents().find('#' + elementID).prev().attr('src', "//player.vimeo.com/video/" + $('#video_Tab input#vimeoID').val() + "?title=0&amp;byline=0&amp;portrait=0");

                }

            }

            /* END SANDBOX */

        }


        $('#detailsAppliedMessage').fadeIn(600, function () {

            setTimeout(function () {
                $('#detailsAppliedMessage').fadeOut(1000)
            }, 3000)

        });

        heightAdjustment(el);

        setPendingChanges(true);

    });


    //delete button
    $('button#removeElementButton').unbind('click').bind('click', function () {

        var toDel;
        var randomEl;

        if ($(el).prop('tagName') == 'A') {//ancor

            if ($(el).parent().prop('tagName') == 'LI') {//clone the LI

                toDel = $(el).parent();

            } else {

                toDel = $(el);

            }

        } else if ($(el).prop('tagName') == 'IMG') {//image

            if ($(el).parent().prop('tagName') == 'A') {//clone the A

                toDel = $(el).parent();

            } else {

                toDel = $(el);

            }

        } else {//everything else

            toDel = $(el);

        }

        $('#styleEditor').on('click', 'button#removeElementButton', function () {

            $('#deleteElement').modal('show');

            $('#deleteElement button#deleteElementConfirm').unbind('click').bind('click', function () {

                toDel.fadeOut(500, function () {

                    randomEl = $(this).closest('body').find('*:first');

                    toDel.remove();

                    heightAdjustment(randomEl[0])

                });

                $('#deleteElement').modal('hide');

                closeStyleEditor();

            });

        });

    });


    //clone button
    $('button#cloneElementButton').unbind('click').bind('click', function () {

        var theClone;
        var theOne;
        var cloned;
        var cloneParent;

        if ($(el).parent().hasClass('propClone')) {//clone the parent element

            theClone = $(el).parent().clone();
            theClone.find($(el).prop('tagName')).attr('style', '');

            theOne = theClone.find($(el).prop('tagName'));
            cloned = $(el).parent();

            cloneParent = $(el).parent().parent();

        } else {//clone the element itself

            theClone = $(el).clone();
            theClone.attr('style', '');

            theOne = theClone;
            cloned = $(el);

            cloneParent = $(el).parent();

        }

        cloned.after(theClone);

        //theClone.insertAfter( cloned );


        for (var key in editableItems) {

            $(el).closest('body').find(pageContainer + ' ' + key).each(function () {

                if ($(this)[0] === $(theOne)[0]) {

                    theOne.hover(function () {

                        if ($(this).closest('body').width() != $(this).width()) {

                            $(this).css({'outline': '3px dashed red', 'cursor': 'pointer'});

                        } else {

                            $(this).css({'outline': '3px dashed red', 'outline-offset': '-3px', 'cursor': 'pointer'});

                        }

                    }, function () {

                        if ($(this).closest('body').width() != ($(this).width() + 6)) {

                            $(this).css({'outline': '', 'cursor': ''});

                        } else {

                            $(this).css({'outline': '', 'cursor': '', 'outline-offset': ''});

                        }

                    }).click(function (e) {

                        e.preventDefault();

                        e.stopPropagation();

                        styleClick(this, key)


                    }).each(function () {

                        $(this).attr('data-selector', key)

                    });

                }
            });

        }

        //possible height adjustments

        heightAdjustment(el);

    });


    //reset button
    $('button#resetStyleButton').unbind('click').bind('click', function () {

        if ($(el).closest('body').width() != $(el).width()) {

            $(el).attr('style', '').css({'outline': '3px dashed red', 'cursor': 'pointer'});

        } else {

            $(el).attr('style', '').css({'outline': '3px dashed red', 'outline-offset': '-3px', 'cursor': 'pointer'});

        }

        $('#styleEditor form#stylingForm').height($('#styleEditor form#stylingForm').height() + "px");

        $('#styleEditor form#stylingForm .form-group:not(#styleElTemplate)').fadeOut(500, function () {

            $(this).remove()

        });

        //reset icon

        if (_oldIcon[$(el).attr('id')] != null) {

            var get = $.grep(el.className.split(" "), function (v, i) {

                return v.indexOf('fa-') === 0;

            }).join();

            $(el).removeClass(get).addClass(_oldIcon[$(el).attr('id')]);

            $('select#icons option').each(function () {

                if ($(this).val() == _oldIcon[$(el).attr('id')]) {

                    $(this).attr('selected', true);

                    $('#icons').trigger('chosen:updated');

                }

            });

        }

        setTimeout(function () {
            buildeStyleElements(el, theSelector)
        }, 550)

    });




}


function closeStyleEditor() {

    //only if visible

    if ($('#styleEditor').css('left') == '0px') {

        $('#styleEditor').animate({'left': '-300px'}, 250);

        $('#pageList ul li iframe').each(function () {

            //remove hover events used by Styling modus

            for (var key in editableItems) {

                $(this).contents().find(pageContainer + ' ' + key).unbind('mouseenter mouseleave click').css({'outline': '', 'cursor': ''});

            }


            if ($('input:radio[name=mode]:checked').val() == 'styling') {

                $('#pageList ul li iframe').each(function () {

                    for (var key in editableItems) {

                        $(this).contents().find(pageContainer + ' ' + key).hover(function (e) {

                            e.stopPropagation();

                            if ($(this).closest('body').width() != $(this).width()) {

                                $(this).css({'outline': '3px dashed red', 'cursor': 'pointer'});

                            } else {

                                $(this).css({'outline': '3px dashed red', 'outline-offset': '-3px', 'cursor': 'pointer'});

                            }

                        }, function () {

                            if ($(this).closest('body').width() != ($(this).width() + 6)) {

                                $(this).css({'outline': '', 'cursor': ''});

                            } else {

                                $(this).css({'outline': '', 'cursor': '', 'outline-offset': ''});

                            }

                        }).click(function (e) {

                            e.preventDefault();

                            e.stopPropagation();

                            styleClick(this, key)

                        });

                    }

                });

            }

        });

    }

}


$(function () {

    var _mode;

    //video ID toggle

    $('input#youtubeID').focus(function () {

        $('input#vimeoID').val('');

    });

    $('input#vimeoID').focus(function () {

        $('input#youtubeID').val('');

    });


    //chosen font-awesome dropdown

    $('select#icons').chosen({
        'search_contains': true
    });

    //detect mode
    _mode = "server";
    if (window.location.protocol == 'file:') {

        _mode = "local";

    }
    //check if formData is supported
    if (!window.FormData) {

        //not supported, hide file upload
        $('form#imageUploadForm').hide();

        $('.imageFileTab .or').hide();

    }

    //internal links dropdown

    $('select#internalLinksDropdown').selectpicker({style: 'btn-sm btn-default', menuStyle: 'dropdown-inverse'});
    $('select#internalLinksDropdown').change(function () {

        $('select#pageLinksDropdown option').attr('selected', false);

        $('.link_Tab .btn-group.select:eq(1) .dropdown-menu li').removeClass('selected');

        $('.link_Tab .btn-group.select:eq(1) > button .filter-option').text($('.link_Tab .btn-group.select:eq(1) .dropdown-menu li:first').text())

    });

    $('select#pageLinksDropdown').selectpicker({style: 'btn-sm btn-default', menuStyle: 'dropdown-inverse'});

    $('select#pageLinksDropdown').change(function () {

        $('select#internalLinksDropdown option').attr('selected', false);

        $('.link_Tab .btn-group.select:eq(0) .dropdown-menu li').removeClass('selected');

        $('.link_Tab .btn-group.select:eq(0) > button .filter-option').text($('.link_Tab .btn-group.select:eq(0) .dropdown-menu li:first').text())

    });


    $('input#internalLinksCustom').focus(function () {

        $('select#internalLinksDropdown option').attr('selected', false);
        $('select#pageLinksDropdown option').attr('selected', false);

        $('.link_Tab .dropdown-menu li').removeClass('selected');

        $('.link_Tab .btn-group.select > button .filter-option').text($('.link_Tab .dropdown-menu li:first').text())

        this.select();

    });


    $('#detailsAppliedMessageHide').click(function () {

        $(this).parent().fadeOut(500)

    });


    //hide style editor option?

    if (typeof editableItems === 'undefined') {

        $('#modeStyle').parent().remove();

    }

    $('#closeStyling').click(function () {

        closeStyleEditor();

    });


    $('#styleEditor form').on("focus", "input", function () {

        $(this).css('position', 'absolute');
        $(this).css('right', '0px')

        $(this).animate({'width': '100%'}, 500);

        $(this).focus(function () {
            this.select();
        });

    }).on("blur", "input", function () {

        $(this).animate({'width': '42%'}, 500, function () {

            $(this).css('position', 'relative');
            $(this).css('right', 'auto');

        });

    });


    $('#menu #second ul>li').each(function(){
        $(this).find('iframe').zoomer({
            zoom: 0.25,
            width: 270,
            height: $(this).attr('height'),
            message: "Перетащи меня!"
        });

        //draggables
        makeDraggable('#page1')
    });

    //main menu hide/show



    $('#menu').mouseenter(function () {

        $(this).stop().animate({'left': '0px'}, 500);

    }).mouseleave(function () {

        $(this).stop().animate({'left': '-190px'}, 500);

    });

    //use function call to make the ULs sortable
    makeSortable($('#pageList ul#page1'));

    //second menu animation
    $('#menu #main #elements').on('click', 'a:not(.btn)', function () {

        $('#menu #main a').removeClass('active');
        $(this).addClass('active');

        //show only the right elements
        $('#menu #second ul li').hide();
        $('#menu #second ul li.' + $(this).attr('id')).show();

        if ($(this).attr('id') == 'all') {

            $('#menu #second ul li').show();

        }

        $('.menu .second').css('display', 'block').stop().animate({
            width: secondMenuWidth
        }, 500);


    });

    //second nav hide button
    $('#menu').mouseleave(function () {

        $('#menu #main a').removeClass('active');

        $('.menu .second').stop().animate({
            width: 0
        }, 500, function () {

            $('#menu #second').hide();

        });

    });


    $('#menu #main').on('click', 'a:not(.actionButtons)', function (e) {

        e.preventDefault();

    });

    $('#menu').mouseleave(function () {

        $('#menu #main a').removeClass('active');

        $('.menu .second').stop().animate({
            width: 0
        }, 500, function () {

            $('#menu #second').hide();

        });

    });

    $('#hideSecond').on('click',function(){
        $('.menu .second').stop().animate({
            width: 0
        }, 500, function () {

            $('#menu #second').hide();

        });
    });


    //disable on load
    $('input:radio[name=mode]').parent().addClass('disabled');
    $('input:radio[name=mode]#modeBlock').radio('check');


    var elToUpdate;


    //design mode toggle
    $('input:radio[name=mode]').on('toggle', function () {
        //close style editor
        closeStyleEditor();

        //hide all iframe covers and activate designMode

        $('#pageList ul .frameCover').each(function () {

            $(this).hide();

        });



        $('#pageList ul li iframe').each(function () {


            //remove old click events

            for (var key in editableItems) {

                $(this).contents().find(pageContainer + ' ' + key).unbind('hover').unbind('click');

            }

        });



        if ($(this).val() == 'content') {

            //active content edit mode
            $('#pageList ul li iframe').each(function () {


                for (var i = 0; i < editableContent.length; ++i) {

                    //remove old events
                    $(this).contents().find(pageContainer + ' ' + editableContent[i]).unbind('click').unbind('hover');


                    $(this).contents().find(pageContainer + ' ' + editableContent[i]).hover(function () {

                        $(this).css({'outline': '3px dashed red', 'cursor': 'pointer'});

                    }, function () {

                        $(this).css({'outline': '', 'cursor': ''});

                    }).click(function (e) {

                        elToUpdate = $(this);

                        e.preventDefault();

                        e.stopPropagation();

                        $('#editContentModal #contentToEdit').val($(this).html())

                        $('#editContentModal').modal('show');

                        //for the elements below, we'll use a simplyfied editor, only direct text can be done through this one
                        if (this.tagName == 'SMALL' || this.tagName == 'A' || this.tagName == 'LI' || this.tagName == 'SPAN' || this.tagName == 'B' || this.tagName == 'I' || this.tagName == 'TT' || this.tageName == 'CODE' || this.tagName == 'EM' || this.tagName == 'STRONG' || this.tagName == 'SUB' || this.tagName == 'BUTTON' || this.tagName == 'LABEL' || this.tagName == 'P' || this.tagName == 'H1' || this.tagName == 'H2' || this.tagName == 'H2' || this.tagName == 'H3' || this.tagName == 'H4' || this.tagName == 'H5' || this.tagName == 'H6') {

                            $('#editContentModal #contentToEdit').redactor({
                                buttons: ['html', 'bold', 'italic', 'deleted'],
                                focus: true,
                                plugins: ['bufferbuttons'],
                                buttonSource: true,
                                paragraphize: false,
                                linebreaks: true
                            });

                        } else if (this.tagName == 'DIV' && $(this).hasClass('tableWrapper')) {

                            $('#editContentModal #contentToEdit').redactor({
                                buttons: ['html', 'formatting', 'bold', 'italic', 'deleted', 'table', 'image', 'link', 'alignment'],
                                focus: true,
                                plugins: ['table', 'bufferbuttons'],
                                buttonSource: true,
                                paragraphize: false,
                                linebreaks: false
                            });

                        } else {

                            $('#editContentModal #contentToEdit').redactor({
                                buttons: ['html', 'formatting', 'bold', 'italic', 'deleted', 'unorderedlist', 'orderedlist', 'outdent', 'indent', 'image', 'file', 'link', 'alignment', 'horizontalrule'],
                                focus: true,
                                buttonSource: true,
                                paragraphize: false,
                                linebreaks: false
                            });
                        }


                    }).each(function () {

                        $(this).attr('data-selector', i)

                    });

                }

            });



        } else if ($(this).val() == 'block') {

            //show all iframe covers and activate designMode

            $('#pageList ul .frameCover').each(function () {

                $(this).show();
                $(this).css('height','100%');

            });

            //deactivate designmode

            $('#pageList ul li iframe').each(function () {


                for (var key in editableItems) {

                    $(this).contents().find(pageContainer + ' ' + key).unbind('mouseenter mouseleave');

                }

                this.contentDocument.designMode = "off";

            });

        } else if ($(this).val() == 'styling') {

            //active styling mode
            $('#pageList ul li iframe').each(function () {


                //remove old click events
                $(this).contents().find(pageContainer + ' p').unbind('click').unbind('hover');


                for (var key in editableItems) {

                    $(this).contents().find(pageContainer + ' ' + key).hover(function (e) {

                        e.stopPropagation();

                        if ($(this).closest('body').width() != $(this).width()) {

                            $(this).css({'outline': '3px dashed red', 'cursor': 'pointer'});

                        } else {

                            $(this).css({'outline': '3px dashed red', 'outline-offset': '-3px', 'cursor': 'pointer'});

                        }

                    }, function () {

                        $(this).css({'outline': '', 'cursor': '', 'outline-offset': ''});

                    }).click(function (e) {

                        e.preventDefault();

                        e.stopPropagation();

                        styleClick(this, key)


                    }).each(function () {

                        $(this).attr('data-selector', key)

                    });

                }

            });

        }

    });


    $('button#updateContentInFrameSubmit').click(function () {

        var sandboxID;

        //alert( elToUpdate.text() )

        elToUpdate.html($('#editContentModal #contentToEdit').redactor('code.get')).css({'outline': '', 'cursor': ''});

        /* SANDBOX */

        sandboxID = hasSandbox(elToUpdate)

        if (sandboxID) {

            elementID = elToUpdate.attr('id');

            $('#' + sandboxID).contents().find('#' + elementID).html($('#editContentModal #contentToEdit').redactor('code.get'));

        }

        /* END SANDBOX */

        $('#editContentModal textarea').each(function () {

            $(this).redactor('core.destroy');
            $(this).val('');

        });

        $('#editContentModal').modal('hide');

        $(this).closest('body').removeClass('modal-open').attr('style', '');

        //reset iframe height
        heightAdjustment(elToUpdate.get(0));

        //element was deleted, so we've got pending changes
        setPendingChanges(true)

    });


    //close styleEditor
    $('#styleEditor > a.close').click(function (e) {

        e.preventDefault();

        closeStyleEditor();

    });


    //delete blocks from window

    var blockToDelete;

    $('#pageList').on("click", ".frameCover > .deleteBlock", function () {

        $('#deleteBlock').modal('show');

        blockToDelete = $(this).closest('li');

        $('#deleteBlock').off('click', '#deleteBlockConfirm').on('click', '#deleteBlockConfirm', function () {


            /* SANDBOX */

            var attr = blockToDelete.find('iframe').attr('data-sandbox');

            if (typeof attr !== typeof undefined && attr !== false) {

                //has sandbox, delete it
                $('#sandboxes #' + attr).remove();

            }

            /* END SANDBOX */


            $('#deleteBlock').modal('hide');

            blockToDelete.fadeOut(500, function () {

                $(this).remove();

                pageEmpty();

                allEmpty();

                setPendingChanges(true)

            });

        });

    });


    //reset block
    $('#pageList').on("click", ".frameCover > .resetBlock", function () {

        $('#resetBlock').modal('show');

        var frameToReset = $(this).closest('li').find('iframe');

        $('#resetBlock').off('click', '#resetBlockConfirm').on('click', '#resetBlockConfirm', function () {

            $('#resetBlock').modal('hide');

            frameToReset.get(0).contentWindow.location.reload();

            /* SANDBOX */

            var attr = frameToReset.attr('data-sandbox');

            if (typeof attr !== typeof undefined && attr !== false) {

                //has sandbox, reset it
                document.getElementById(attr).contentDocument.location.reload(true);

            }

            /* END SANDBOX */

        });

    });


    var aceEditors = [];//store all ace editors


    //block source code
    $('#pageList').on("click", ".frameCover > .htmlBlock", function () {

        //hide the iframe
        $(this).closest('.li').find('iframe').hide();


        //disable draggable on the LI
        $(this).closest('li').parent().sortable('disable');


        //built editor element
        var theEditor = $('<div class="aceEditor"></div>');
        theEditor.uniqueId();

        //set the editor height
        if ($(this).closest('li').height() < 300){
            $(this).closest('li').height(300);
            theEditor.height(300);
        } else {
            theEditor.height($(this).closest('li').height());
        }

        $(this).closest('li').append(theEditor);

        var theId = theEditor.attr('id');

        var editor = ace.edit(theId);

        //sandbox?

        var attr = $(this).closest('li').find('iframe').attr('data-sandbox');

        if (typeof attr !== typeof undefined && attr !== false) {

            editor.setValue($('#sandboxes #' + attr).contents().find(pageContainer).html());

            //has sandbox, reset it
            document.getElementById(attr).contentDocument.location.reload(true);

        } else {

            editor.setValue($(this).closest('li').find('iframe').contents().find(pageContainer).html());

        }


        editor.setTheme("ace/theme/twilight");
        editor.getSession().setMode("ace/mode/html");

        //buttons

        var cancelButton = $('<button type="button" class="btn btn-danger editCancelButton btn-wide"><span class="fui-cross"></span> Отмена</button>');
        var saveButton = $('<button type="button" class="btn btn-primary editSaveButton btn-wide"><span class="fui-check"></span> Сохранить</button>');

        var buttonWrapper = $('<div class="editorButtons"></div>');
        buttonWrapper.append(cancelButton);
        buttonWrapper.append(saveButton);

        $(this).closest('li').append(buttonWrapper);

        aceEditors[ theId ] = editor;

    });


    $('#pageList').on("click", "li .editorButtons .editCancelButton", function () {

        heightAdjustment( $(this).closest('li').find('iframe').attr('id'), true );

        //theId = $(this).closest('.editorButtons').prev().attr('id');

        //enable draggable on the LI
        $(this).closest('li').parent().sortable('enable');

        $(this).parent().prev().remove();

        $(this).closest('li').find('.zoomer-small iframe').fadeIn(500);

        $(this).parent().fadeOut(500, function () {

            $(this).remove();

        });

    });


    $('#pageList').on("click", "li .editorButtons .editSaveButton", function () {

        //enable draggable on the LI
        $(this).closest('li').parent().sortable('enable');


        var theId = $(this).closest('.editorButtons').prev().attr('id');

        var theContent = aceEditors[theId].getValue();

        var theiFrame = $(this).closest('li').find('iframe');


        $(this).parent().prev().remove();



        //theiFrame.contents().find( pageContainer ).html( theContent );


        /* SANDBOX */

        var attr = $(this).closest('li').find('iframe').attr('data-sandbox');

        if (typeof attr !== typeof undefined && attr !== false) {

            $('#sandboxes #' + attr).contents().find(pageContainer).html(theContent);


            $(this).closest('li').find('iframe').show().contents().find(pageContainer).html(theContent);

            //do we need to execute a loader function?
            if (typeof theiFrame.attr('data-loaderfunction') !== typeof undefined && theiFrame.attr('data-loaderfunction') !== false) {

                var codeToExecute = "theiFrame[0].contentWindow." + theiFrame.attr('data-loaderfunction') + "()";
                var tmpFunc = new Function(codeToExecute);
                tmpFunc();

            }

        } else {

            $(this).closest('li').find('iframe').show().contents().find(pageContainer).html(theContent);

        }

        /* END SANDBOX */

        //height adjustment
        heightAdjustment($(this).closest('li').find('iframe').attr('id'), true);


        $(this).parent().fadeOut(500, function () {

            $(this).remove();

        });

        setPendingChanges(true)

    });



    //save page
    $('#savePage').click(function (e) {

        e.preventDefault();
        savePage(e);

    });



    //preview
    $('#previewModal').on('show.bs.modal', function (e) {

        $('#previewModal > form #showPreview').show('');

        $('#previewModal > form #previewCancel').text('Закрыть');

        closeStyleEditor();

    });

    $('#previewModal').on('shown.bs.modal', function (e) {

        var newDocMainParent;
        var theContents;

        $('#previewModal form input[type="hidden"]').remove();

        //grab visible page
        $('#pageList > ul:visible').each(function () {

            //grab the skeleton markup

            newDocMainParent = $('iframe#skeleton').contents().find(pageContainer);

            //empty out the skeleton
            newDocMainParent.find('*').remove();

            $(this).find('iframe').each(function () {


                //sandbox or regular?

                var attr = $(this).attr('data-sandbox');

                if (typeof attr !== typeof undefined && attr !== false) {

                    theContents = $('#sandboxes #' + attr).contents().find(pageContainer);

                } else {

                    theContents = $(this).contents().find(pageContainer);

                }


                //remove .frameCovers

                theContents.find('.frameCover').each(function () {
                    $(this).remove();
                });


                //remove inline styling leftovers

                for (var key in editableItems) {

                    //alert('Key :'+key)

                    theContents.find(key).each(function () {

                        //alert( "Data before: "+ $(this).attr('data-selector') );

                        $(this).removeAttr('data-selector');

                        //alert( "Data after: "+ $(this).attr('data-selector') );

                        if ($(this).attr('style') == '') {
                            $(this).removeAttr('style')
                        }

                    });

                }
                for (var i = 0; i < editableContent.length; ++i) {

                    $(this).contents().find(editableContent[i]).each(function () {

                        $(this).removeAttr('data-selector');

                    });

                }


                var toAdd = theContents.html();

                //grab scripts

                var scripts = $(this).contents().find(pageContainer).find('script');

                if (scripts.size() > 0) {

                    var theIframe = document.getElementById("skeleton");

                    scripts.each(function () {

                        if ($(this).text() != '') {//script tags with content

                            var script = theIframe.contentWindow.document.createElement("script");
                            script.type = 'text/javascript';
                            script.innerHTML = $(this).text();

                            theIframe.contentWindow.document.getElementById(pageContainer.substring(1)).appendChild(script);

                        } else if ($(this).attr('src') != null) {

                            var script = theIframe.contentWindow.document.createElement("script");
                            script.type = 'text/javascript';
                            script.src = $(this).attr('src');

                            theIframe.contentWindow.document.getElementById(pageContainer.substring(1)).appendChild(script)

                        }

                    });

                }

                newDocMainParent.append($(toAdd));

            });

            var newInput = $('<input type="hidden" name="page" value="">');

            $('#previewModal form').prepend(newInput);

            newInput.val("<html>" + $('iframe#skeleton').contents().find('html').html() + "</html>")

        });

    });

    $('#previewModal > form').submit(function () {

        $('#previewModal > form #showPreview').hide('');

        $('#previewModal > form #previewCancel').text('Закрыть');

    });


    $('#xsDgnInput').on('change', function () {
//        var ext = $('#xsDgnInput').val().split('.').pop().toLowerCase();
        var ext = this.value.match(/\.(.+)$/)[1];
        if ($.inArray(ext, ['xs']) == -1) {
            var msg = 'Please upload save Project file!';

            $("#xsErrorModal .modal-body").html(msg);
            //$("#xsImpModal").modal('hide');
            $("#xsErrorModal").modal('show');
        } else {
            $("#xsclearCanvas").modal('show');
            $("#xsImpModal").modal('hide');
        }

    });

    $("#xsclearCanvasImport").on('click', function () {
        $("#xsImportForm").submit();
    });

    //end ar2


    //export markup

    $('#metaModal').on('show.bs.modal', function (e) {

        $('#metaModal > form #exportSubmit').show('');

        $('#metaModal > form #exportCancel').text('Отменить и закрыть');

        closeStyleEditor();

    });

    $('#metaModal > form').on('submit',function(ev) {
        ev.preventDefault();

        savePage(ev);

        var form = $(this);
        var formAction = form.attr('action');

        $.ajax({
            url: formAction,
            data: form.serializeArray(),
            type: 'POST',
        }).done(function (response,status,xhr) {
            // alert(xhr.status);
            if (xhr.status == 401) {
                $('#auth .modal').modal('show');
            } else {
                console.log('Metas Saved');
            }
        }).fail(function (response,status,xhr) {
            alert('Ошибка Metas')
        });

    });

    $('#metaModal').on('shown.bs.modal', function (e) {

        $('#iconInput').on('click', function(e){
            e.preventDefault();
            $('#uploadIcon').click();
        });


        // $('#type_widget').val(editor.getSession().getValue());


        var newInput = $('<input type="hidden" name="alias_id" value="' + $('#selectAlias').val() + '">');

        $('#metaModal form').prepend(newInput);

        $('#uploadIcon').on('change',function(ev){

            var form = $('form#uploadIconForm');

            var formdata = false;

            if (window.FormData) {
                formdata = new FormData(form[0]);
            }

            var formAction = form.attr('action');

            $.ajax({
                url: formAction,
                data: formdata ? formdata : form.serialize(),
                cache: false,
                contentType: false,
                processData: false,
                dataType: "json",
                type: 'POST',
            }).done(function (response,status) {
                if (status == 401) {
                    $('#auth.modal').modal('show');
                } else {
                    $('#img_icon').attr('src',response.response);
                    $('#export_icon').val(response.response);
                }
            }).fail(function (response,status) {
                if (status == 401) {
                    $('#auth.modal').modal('show');
                }
            });
        });

        $.ajax({
            url: '/builder/metas/' + $('#selectDomain').val(),
            dataType: "json",
            type: 'GET',
        }).done(function (response,status,xhr) {

            // alert(xhr.status);
            if (xhr.status == 401) {
                $('#metaModal').modal('hide');
                $('#auth .modal').modal('show');
            } else {
                for(var i = 0; i < response.length; i++) {
                    if(response[i].name === 'icon') {
                        $('#img_' + response[i].name).attr('src',response[i].content);
                    }

                    $('#export_' + response[i].name).val(response[i].content);
                }


                var editorWidget = ace.edit('editorWidget');

                editorWidget.setTheme("ace/theme/twilight");
                editorWidget.getSession().setMode("ace/mode/html");
                editorWidget.getSession().setValue($('#export_widget').val());
                editorWidget.getSession().on("change", function () {
                    $('#export_widget').val(editorWidget.getSession().getValue());
                });

                var editorStyle = ace.edit('editorStyle');

                editorStyle.setTheme("ace/theme/twilight");
                editorStyle.getSession().setMode("ace/mode/css");
                editorStyle.getSession().setValue($('#export_style').val());
                editorStyle.getSession().on("change", function () {
                    $('#export_style').val(editorStyle.getSession().getValue());
                });

                $('#removeFavIcon').on('click',function(){
                    $('#export_icon').val('');
                    $('#img_icon').attr('src','/images/favicon.ico');
                });
            }
        }).fail(function (response,status,xhr) {
            // window.location.reload();
            //$('#auth .modal').modal('show');
            alert('Ошибка!');
            // $('#metaModal').modal('hide');
        });
    });



    $('#metaModal > form').submit(function () {

        $('#metaModal').modal('hide');

    });


    //clear screen
    $('#clearScreen').click(function () {

        $('#deleteAll').modal('show');

        $('#deleteAll').on('click', '#deleteAllConfirm', function () {

            $('#deleteAll').modal('hide');

            $('#pageList ul:visible li').fadeOut(500, function () {

                $(this).remove();

                pageEmpty();

                allEmpty();

            });

            //remove possible sandboxes
            $('#sandboxes iframe').each(function () {

                $(this).remove();

            });

        });

        setPendingChanges(true);

    });


    //page menu buttons



    //add page

    $('#pages').on('blur', 'li > input', function () {

        if ($(this).parent().find('a.plink').size() == 0) {

            theLink = $('<a href="#' + $(this).val() + '" class="plink">' + $(this).val() + '</a>');

            $(this).hide();

            $(this).closest('li').prepend(theLink);

            $(this).closest('li').removeClass('edit');


            //update the page dropdown

            $('#internalLinksDropdown option:eq(' + $(this).parent().index() + ')').text($(this).val()).attr('value', $(this).val() + ".html");

            $('select#internalLinksDropdown').selectpicker({style: 'btn-sm btn-default', menuStyle: 'dropdown-inverse'});

            //alert( ($(this).parent().index())+" : "+$(this).val() )


            $(this).remove();

        }

    });

    $('#addPage').click(function (e) {

        e.preventDefault();

        //turn inputs into links
        $('#pages li.active').each(function () {

            if ($(this).find('input').size() > 0) {

                var theLink = $('<a href="#">' + $(this).find('input').val() + '</a>');

                $(this).find('input').remove();

                $(this).prepend(theLink);

            }

        });

        $('#pages li').removeClass('active');

        var newPageLI = $('#newPageLI').clone();
        newPageLI.css('display', 'block');
        newPageLI.find('input').val('page' + $('#pages li').size());
        newPageLI.attr('id', '');

        $('ul#pages').append(newPageLI);


        var theInput = newPageLI.find('input');

        theInput.focus();

        var tmpStr = theInput.val();
        theInput.val('');
        theInput.val(tmpStr);

        theInput.keyup(function () {

            $('#pageTitle span span').text($(this).val())

        });

        newPageLI.addClass('active').addClass('edit');


        //create the page structure

        var newPageList = $('<ul></ul>');
        newPageList.css('display', 'block');
        newPageList.attr('id', 'page' + ($('#pages li').size() - 1));

        $('#pageList > ul').hide();
        $('#pageList').append(newPageList);


        makeSortable(newPageList);

        //draggables
        makeDraggable('#' + 'page' + ($('#pages li').size() - 1))


        //alter page title
        $('#pageTitle span span').text('page' + ($('#pages li').size() - 1));

        $('#frameWrapper').addClass('empty')
        $('#start').fadeIn();


        //add page to page dropdown

        var newItem = $('<option value="' + 'page' + ($('#pages li').size() - 1) + '.html">' + 'page' + ($('#pages li').size() - 1) + '</option>')

        $('#internalLinksDropdown').append(newItem);

        $('select#internalLinksDropdown').selectpicker({style: 'btn-sm btn-default', menuStyle: 'dropdown-inverse'});

        //new page added, we've got pending changes
        setPendingChanges(true);

    });


    $('#pages').on('click', 'li:not(.active)', function () {

        $('#pageList > ul').hide();

        $('#pageList > ul:eq(' + ($(this).index() - 1) + ')').show();

        pageEmpty();

        //draggables
        makeDraggable('#' + 'page' + ($(this).index()))

        $('#pages li').removeClass('active').removeClass('edit');

        $(this).addClass('active');

        $('#pageTitle span span').text($(this).find('a').text());

    });


    $('#pages').on('click', 'li.active .fileSave', function () {

        //do something

        var theLI = $(this).closest('li');

        if (theLI.find('input').size() > 0) {

            var theLink = $('<a href="#' + theLI.find('input').val() + '">' + theLI.find('input').val() + '</a>');

            theLI.find('input').remove();

            theLI.prepend(theLink);

        }

        $('#pages li').removeClass('edit');

    });


    //edit page button

    $('#pages').on('click', 'li.active .fileEdit', function () {


        var theLI = $(this).closest('li');

        var newInput = $('<input type="text" value="' + theLI.find('a:first').text() + '" name="page">');

        theLI.find('a:first').remove();

        theLI.prepend(newInput);

        newInput.focus();

        var tmpStr = newInput.val();
        newInput.val('');
        newInput.val(tmpStr);

        newInput.keyup(function () {

            $('#pageTitle span span').text($(this).val())

        });

        theLI.addClass('edit');

        //changed page title, we've got pending changes
        setPendingChanges(true);

    });

    var theLIIndex;

    //delete page button
    $('#pages').on('click', 'li.active .fileDel', function () {

        theLIIndex = $(this).parent().parent().index();

        $('#deletePage').modal('show');

        $('#deletePageCancel').click(function () {

            $('#deletePage').modal('hide');

        });

        $('#deletePage').off('click').on('click', '#deletePageConfirm', function (e) {

            $('#deletePage').modal('hide');

            $('#pages li:eq(' + theLIIndex + ')').remove();

            $('#pageList ul:visible').remove();


            //update the page dropdown list

            $('select#internalLinksDropdown option:eq(' + theLIIndex + ')').remove();

            $('.link_Tab .dropdown-menu li:eq(' + theLIIndex + ')').remove();


            //activate the first page

            $('#pages li:eq(1)').addClass('active');

            $('#pageList ul:first').show();

            $('#pageTitle span span').text($('#pages li:eq(1)').find('a:first').text())


            //draggables
            makeDraggable('#' + 'page1')


            //show the start block?

            pageEmpty();

            allEmpty();

            savePage(e);

            //page was deleted, so we've got pending changes
            setPendingChanges(true);


        });

    });


    //content modal, destroy redactor when modal closes
    $('#editContentModal').on('hidden.bs.modal', function (e) {

        $('#editContentModal #contentToEdit').redactor('core.destroy');

    });

});


function savePage(e) {

    var blocks = [];
    closeStyleEditor();

    var pageCounter = 0;

    //frame stuff
    $('#pageList > ul').each(function () {

        blocks[pageCounter] = {
            'element' : [],
            'frame' : [],
            'page' : []
        };

        var theName = $(this).attr('id');

        var theContents = "";

        $(this).find('li').each(function () {
            blocks[pageCounter].frame.push($(this).html());
        });

        $(this).find('iframe').each(function () {

            var attr = $(this).attr('data-sandbox');

            if (typeof attr !== typeof undefined && attr !== false) {

                theContents = $('#sandboxes #' + attr).contents().find(pageContainer);

            } else {

                theContents = $(this).contents().find(pageContainer);

            }


            //remove .frameCovers

            theContents.find('.frameCover').each(function () {
                $(this).remove();
            });


            //remove inline styling leftovers

            for (var key in editableItems) {

                //alert('Key :'+key)

                theContents.find(key).each(function () {

                    //alert( "Data before: "+ $(this).attr('data-selector') );
                    //rm1
        	        $(this).removeAttr('data-selector');
                    //rm1
                    //alert( "Data after: "+ $(this).attr('data-selector') );

                    if ($(this).attr('style') == '') {
                        $(this).removeAttr('style')
                    }

                });

            }
            //rm1
            for (var i = 0; i < editableContent.length; ++i) {

                $(this).contents().find(editableContent[i]).each(function () {

                    $(this).removeAttr('data-selector');

                });

            }
            //rm1

            blocks[pageCounter].element.push(theContents.html());

        });

        pageCounter++;

    });

    //page names
    var c = 0;
    $('ul#pages li:not(#newPageLI)').each(function (index) {
        blocks[c].page = $(this).find('a').text();
        c++;
    });

    //console.log(blocks);

    var form = $('#savePageForm');
    var formAction = form.attr('action');

    $.ajax({
        url: formAction,
        data: JSON.stringify({ 'domain_id' : $('#selectDomain').val(), blocks: blocks }),
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        type: 'POST',
    }).done(function (response,status,xhr) {
        // alert(xhr.status);
        if (xhr.status == 401) {
            $('#auth .modal').modal('show');
        } else {
            setPendingChanges(false);
        }
    }).fail(function (response,status,xhr) {
        // window.location.reload();
        $('#auth .modal').modal('show');
    });
    

}