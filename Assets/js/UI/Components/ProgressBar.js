Amarkal.UI.register({
    wrapper: '.afw-ui-component-progressbar',
    getInput: function( wrapper ) {
        return false;
    },
    setValue: function( wrapper, value ) {
        var pb = $(wrapper).find('.progressbar'),
            max = parseFloat( pb.attr('data-max') ),
            width = (value/max)*100;
        $(wrapper).find('.progressbar-inner').css({width: width+'%'});
        $(wrapper).find('.progressbar-label').text(value+'/'+max);
    },
    init: function( wrapper ) {
        var pb = $(wrapper).find('.progressbar'),
            value = parseFloat( pb.attr('data-value') ),
            max = parseFloat( pb.attr('data-max') ),
            width = (value/max)*100,
            outer = $('<div></div>'),
            inner = $('<div></div>'),
            label = $('<div></div>');
        
        outer.addClass('progressbar-outer');
        inner.addClass('progressbar-inner').css({width: width+'%'});
        label.addClass('progressbar-label').text(value+'/'+max);
        
        outer.append(inner);
        pb.append(outer,label);
    }
});