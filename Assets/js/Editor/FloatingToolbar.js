/**
 * Implements a floating toolbar for the TinyMCE visual editor.
 * Most of this code is a reformatted version of the code seen at
 * wp-includes/js/tinymce/plugins/wpeditimage/plugin.js
 */
Amarkal.Editor.FloatingToolbar = function( editor, settings ) 
{
    this.settings = settings;
    this.editor = editor;
    this.init();
};

Amarkal.Editor.FloatingToolbar.prototype.init = function() 
{
    var floatingToolbar, serializer,
        editor = this.editor,
        DOM = tinymce.DOM,
        settings = editor.settings,
        Factory = tinymce.ui.Factory,
        iOS = tinymce.Env.iOS,
        toolbarIsHidden = true,
        self = this,
        editorWrapParent = tinymce.$( '#postdivrich' );

    function isPlaceholder( node ) {
        return !! ( editor.dom.getAttrib( node, 'data-mce-placeholder' ) || editor.dom.getAttrib( node, 'data-mce-object' ) );
    }
    
    function isSelectorElement( node )
    {
        return node && ( tinymce.$(node).is( self.settings.selector) || tinymce.$(node).parents(self.settings.selector).length !== 0 );
    }

    var i = this.settings.buttons.length;
    while( i-- )
    {
        var button = this.settings.buttons[i];
        editor.addButton( button.slug, {
            tooltip: button.tooltip,
            icon: button.icon,
            onclick: button.onclick
        } );
    }

    floatingToolbar = Factory.create( this.toolbarConfig() ).renderTo( document.body ).hide();

    floatingToolbar.reposition = function() {
        var top, left, minTop, className,
            windowPos, adminbar, mceToolbar, boundary,
            boundaryMiddle, boundaryVerticalMiddle, spaceTop,
            spaceBottom, windowWidth, toolbarWidth, toolbarHalf,
            iframe, iframePos, iframeWidth, iframeHeigth,
            toolbarNodeHeight, verticalSpaceNeeded,
            toolbarNode = this.getEl(),
            buffer = 5,
            margin = 8,
            adminbarHeight = 0,
            node = editor.selection.getNode();
    
        if ( !isSelectorElement( node ) ) {
            return this;
        }
        
        // If this is a child of the real element, select its parent
        if( !tinymce.$(node).is( self.settings.selector) )
        {
            node = tinymce.$(node).parents(self.settings.selector)[0];
        }

        windowPos = window.pageYOffset || document.documentElement.scrollTop;
        adminbar = tinymce.$( '#wpadminbar' )[0];
        mceToolbar = tinymce.$( '.mce-tinymce .mce-toolbar-grp' )[0];
        boundary = node.getBoundingClientRect();
        boundaryMiddle = ( boundary.left + boundary.right ) / 2;
        boundaryVerticalMiddle = ( boundary.top + boundary.bottom ) / 2;
        spaceTop = boundary.top;
        spaceBottom = iframeHeigth - boundary.bottom;
        windowWidth = window.innerWidth;
        toolbarWidth = toolbarNode.offsetWidth;
        toolbarHalf = toolbarWidth / 2;
        iframe = editor.getContentAreaContainer().firstChild;
        iframePos = DOM.getPos( iframe );
        iframeWidth = iframe.offsetWidth;
        iframeHeigth = iframe.offsetHeight;
        toolbarNodeHeight = toolbarNode.offsetHeight;
        verticalSpaceNeeded = toolbarNodeHeight + margin + buffer;

        if ( iOS ) {
            top = boundary.top + iframePos.y + margin;
        } else {
            if ( spaceTop >= verticalSpaceNeeded ) {
                className = ' mce-arrow-down';
                top = boundary.top + iframePos.y - toolbarNodeHeight - margin;
            } else if ( spaceBottom >= verticalSpaceNeeded ) {
                className = ' mce-arrow-up';
                top = boundary.bottom + iframePos.y;
            } else {
                top = buffer;

                if ( boundaryVerticalMiddle >= verticalSpaceNeeded ) {
                    className = ' mce-arrow-down';
                } else {
                    className = ' mce-arrow-up';
                }
            }
        }

        // Make sure the image toolbar is below the main toolbar.
        if ( mceToolbar ) {
            minTop = DOM.getPos( mceToolbar ).y + mceToolbar.clientHeight;
        } else {
            minTop = iframePos.y;
        }

        // Make sure the image toolbar is below the adminbar (if visible) or below the top of the window.
        if ( windowPos ) {
            if ( adminbar && adminbar.getBoundingClientRect().top === 0 ) {
                adminbarHeight = adminbar.clientHeight;
            }

            if ( windowPos + adminbarHeight > minTop ) {
                minTop = windowPos + adminbarHeight;
            }
        }

        if ( top && minTop && ( minTop + buffer > top ) ) {
            top = minTop + buffer;
            className = '';
        }

        left = boundaryMiddle - toolbarHalf;
        left += iframePos.x;

        if ( toolbarWidth >= windowWidth ) {
            className += ' mce-arrow-full';
            left = 0;
        } else if ( ( left < 0 && boundary.left + toolbarWidth > windowWidth ) ||
            ( left + toolbarWidth > windowWidth && boundary.right - toolbarWidth < 0 ) ) {

            left = ( windowWidth - toolbarWidth ) / 2;
        } else if ( left < iframePos.x ) {
            className += ' mce-arrow-left';
            left = boundary.left + iframePos.x;
        } else if ( left + toolbarWidth > iframeWidth + iframePos.x ) {
            className += ' mce-arrow-right';
            left = boundary.right - toolbarWidth + iframePos.x;
        }

        if ( ! iOS ) {
            toolbarNode.className = toolbarNode.className.replace( / ?mce-arrow-[\w]+/g, '' );
            toolbarNode.className += className;
        }

        DOM.setStyles( toolbarNode, { 'left': left, 'top': top } );

        return this;
    };

    if ( iOS ) {
        // Safari on iOS fails to select image nodes in contentEditoble mode on touch/click.
        // Select them again.
        editor.on( 'click', function( event ) {
            if ( isSelectorElement( node ) ) {
                var node = event.target;

                window.setTimeout( function() {
                    editor.selection.select( node );
                }, 200 );
            } else {
                floatingToolbar.hide();
            }
        });
    }

    editor.on( 'nodechange', function( event ) {
        var delay = iOS ? 350 : 100;

        if (  !isSelectorElement( event.element ) || isPlaceholder( event.element ) ) {
            floatingToolbar.hide();
            return;
        }

        setTimeout( function() {
            var element = editor.selection.getNode();

            if ( isSelectorElement( element ) && ! isPlaceholder( element ) ) {
                if ( floatingToolbar._visible ) {
                    floatingToolbar.reposition();
                } else {
                    floatingToolbar.show();
                }
            } else {
                floatingToolbar.hide();
            }
        }, delay );
    } );

    function hide() {
        if ( ! toolbarIsHidden ) {
            floatingToolbar.hide();
        }
    }

    floatingToolbar.on( 'show', function() {
        toolbarIsHidden = false;

        if ( this._visible ) {
            this.reposition();
            DOM.addClass( this.getEl(), 'mce-inline-toolbar-grp-active' );
        }
    } );

    floatingToolbar.on( 'hide', function() {
        toolbarIsHidden = true;
        DOM.removeClass( this.getEl(), 'mce-inline-toolbar-grp-active' );
    } );

    floatingToolbar.on( 'keydown', function( event ) {
        if ( event.keyCode === 27 ) {
            hide();
            editor.focus();
        }
    } );

    DOM.bind( window, 'resize scroll', function() {
        if ( ! toolbarIsHidden && editorWrapParent.hasClass( 'wp-editor-expand' ) ) {
            hide();
        }
    });

    editor.on( 'init', function() {
        editor.dom.bind( editor.getWin(), 'scroll', hide );
    });

    editor.on( 'blur hide', hide );

    // 119 = F8
    editor.shortcuts.add( 'Alt+119', '', function() {
        var node = floatingToolbar.find( 'toolbar' )[0];

        if ( node ) {
            node.focus( true );
        }
    });
};

Amarkal.Editor.FloatingToolbar.prototype.toolbarConfig = function() 
{
    var toolbarItems = [],
        Factory = tinymce.ui.Factory,
        editor = this.editor,
        settings = editor.settings,
        buttonGroup;

    tinymce.each( this.settings.buttons, function( button ) {
        var itemName,
            item = button.slug;

        function bindSelectorChanged() {
            var selection = editor.selection;

            if ( item.settings.stateSelector ) {
                selection.selectorChanged( item.settings.stateSelector, function( state ) {
                    item.active( state );
                }, true );
            }

            if ( item.settings.disabledStateSelector ) {
                selection.selectorChanged( item.settings.disabledStateSelector, function( state ) {
                    item.disabled( state );
                } );
            }
        }

        if ( item === '|' ) {
            buttonGroup = null;
        } else {
            if ( Factory.has( item ) ) {
                item = {
                    type: item
                };

                if ( settings.toolbar_items_size ) {
                    item.size = settings.toolbar_items_size;
                }

                toolbarItems.push( item );

                buttonGroup = null;
            } else {
                if ( ! buttonGroup ) {
                    buttonGroup = {
                        type: 'buttongroup',
                        items: []
                    };

                    toolbarItems.push( buttonGroup );
                }

                if ( editor.buttons[ item ] ) {
                    itemName = item;
                    item = editor.buttons[ itemName ];

                    if ( typeof item === 'function' ) {
                        item = item();
                    }

                    item.type = item.type || 'button';

                    if ( settings.toolbar_items_size ) {
                        item.size = settings.toolbar_items_size;
                    }

                    item = Factory.create( item );
                    buttonGroup.items.push( item );

                    if ( editor.initialized ) {
                        bindSelectorChanged();
                    } else {
                        editor.on( 'init', bindSelectorChanged );
                    }
                }
            }
        }
    } );

    return {
        type: 'panel',
        layout: 'stack',
        classes: 'toolbar-grp inline-toolbar-grp wp-image-toolbar',
        ariaRoot: true,
        ariaRemember: true,
        items: [
            {
                type: 'toolbar',
                layout: 'flow',
                items: toolbarItems
            }
        ]
    };
};