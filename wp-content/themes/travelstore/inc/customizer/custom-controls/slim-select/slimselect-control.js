/**
 * Slim select js.
 * Custom js file to init the slim select in customizeru
 *
 * @link https://slimselectjs.com/
 * @license MIT
 */
(function (api) {

    api.controlConstructor['slim_select'] = api.Control.extend({

        ready: function () {
            var control = this;
            var dropDownID = document.getElementById(`slim-select-${control.id}`);

            /**
             * Initialize the slim select.
             */
            var select = new SlimSelect({
                select: dropDownID,
                beforeOpen: function () {
                    this.slim.content.style.position = 'relative';
                },
                allowDeselect: true
            });

            var getSelectedItem = control.setting.get();
            if ('undefined' !== typeof getSelectedItem) {
                select.set(getSelectedItem);
            }

            this.container.on('change', dropDownID, function () {
                var selectedItem = select.selected();
                control.setting.set(selectedItem);
            });

        }

    });

})(wp.customize);