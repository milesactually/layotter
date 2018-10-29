/**
 * Provides methos to create confirm() and alert() style modals
 */
app.service('modals', function($compile, $rootScope, $timeout){


    // when enter is pressend in a prompt, submit the value
    angular.element(document).on('keydown', '#layotter-modal-prompt-input', function(e){
        if (e.keyCode === 13) {
            $rootScope.prompt.okAction();
        }
    });


    // when ESC is pressed, cancel confirmation or close prompt
    angular.element(document).on('keyup', function(e){
        if (e.keyCode === 27) {
            if (angular.element('.layotter-modal-confirm').length) {
                $rootScope.confirm.cancelAction();
            } else if (angular.element('.layotter-modal-prompt').length) {
                $rootScope.prompt.cancelAction();
            }
        }
    });


    /**
     * Create a confirm()-style modal prompting the user to input a string
     *
     * @param options Confirmation message as well as OK and cancel button texts and actions
     */
    this.prompt = function(options) {
        // try to create the lightbox
        if (!create(angular.element('#layotter-modal-prompt').html())) {
            return;
        }

        $rootScope.prompt = {
            message: options.message,
            initialValue: options.initialValue,
            okText: options.okText,
            cancelText: options.cancelText,
            okAction: function() {
                var $input = angular.element('#layotter-modal-prompt-input');
                var value = $input.val();

                if (value == '') {
                    $input.focus();
                    return;
                }

                close();
                if (typeof options.okAction === 'function') {
                    var newValue = value;
                    options.okAction(newValue);
                }
            },
            cancelAction: function() {
                close();
                if (typeof options.cancelAction === 'function') {
                    options.cancelAction();
                }
            }
        };

        // without the $timeout, pressing ESC in the input field would remove the value
        $timeout(function(){
            angular.element('#layotter-modal-prompt-input').select().focus();
        }, 1);
    };


    /**
     * Create a confirm()-style modal
     *
     * @param options Confirmation message as well as OK and cancel button texts and actions
     */
    this.confirm = function(options) {
        // try to create the lightbox
        if (!create(angular.element('#layotter-modal-confirm').html())) {
            return;
        }

        $rootScope.confirm = {
            message: options.message,
            okText: options.okText,
            cancelText: options.cancelText,
            okAction: function() {
                close();
                if (typeof options.okAction === 'function') {
                    options.okAction();
                }
            },
            cancelAction: function() {
                close();
                if (typeof options.cancelAction === 'function') {
                    options.cancelAction();
                }
            }
        };

        angular.element('#layotter-modal-confirm-button').focus();
    };


    /**
     * Open up the lightbox
     *
     * @param content HTML string to be displayed
     */
    var create = function(content) {
        // only one instance is allowed at any time
        if (angular.element('#dennisbox-modal').length) {
            return false;
        }
        
        var box = angular.element('<div id="dennisbox-modal"><div class="dennisbox-overlay"></div><div class="dennisbox-content"></div></div>');
        var topOffset = parseInt(angular.element(document).scrollTop() + angular.element(window).height() / 2); // vertical center of current screen
        
        box.appendTo('body')
            .find('.dennisbox-content')
                .html(content)
                .css('height', 210)
                .css('width', 350)
                .css('margin-top', -90)
                .css('top', topOffset)
                .css('opacity', 0)
                .animate({ marginTop: -100, opacity: 1 }, 300);

        // compile lightbox contents
        $timeout(function(){
            $rootScope.$apply($compile(angular.element('#dennisbox-modal'))($rootScope));
        },1);

        return true;
    };


    /**
     * Close the lightbox
     */
    var close = function() {
        var box = angular.element('#dennisbox-modal');
        if (box.length) {
            box.children().fadeOut(300, function(){
                angular.element(this).parent().remove();
            });
        }
    }
    
    
});