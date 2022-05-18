/*
 * MIT watermark
 *
 * Copyright (c) 2022 Jeff Bickart
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, subwatermark, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */

({
    className: 'record',
    productKey: null,

    /**
     * Initialization
     */
    initialize: function (options) {
        this._super("initialize", [options]);

        //listen for Save button click in headerpane
        this.context.on('watermark:save', this.handleSave, this);
    },

    loadData: function () {
        app.alert.show('loading', {level: 'process', title: app.lang.get('LBL_LOADING')});
        try {
            this.watermark_code = app.config.watermark;
        } catch (e) {
            this.watermark_code = '';
        }

        app.alert.dismiss('loading');

        // this.context.trigger('watermark:toggle', ! _.isEmpty(this.watermark_code));
        // this.render();
    },

    handleSave: function () {
        var self = this;
        this.context.trigger('watermark:toggle', false);

        app.alert.show('saving', {level: 'process', title: app.lang.get('LBL_SAVING')});

        app.api.call('update', app.api.buildURL('watermark'), {
            'watermark_code': this.$('#watermark_code').val()
        }, {
            success: function (data) {
                if (data.ok) {
                    app.alert.show('success_approve', {
                        level: 'success',
                        messages: app.lang.get('LBL_WATERMARK_SAVED'),
                        autoClose: true
                    });
                    app.config.watermark = data.watermark_code;
                    self.watermark_code = data.watermark_code;
                    self.render();
                } else {
                    app.alert.show('error', {
                        level: 'error',
                        messages: data.message
                    });
                }
            },
            error: function (data) {
                app.alert.show('error', {
                    level: 'error',
                    messages: data.message
                });
            },
            complete: function () {
                app.alert.dismiss('saving');
                self.context.trigger('watermark:toggle', true);
                app.router.navigate("Home", {trigger: true});
            }
        });
    }
})