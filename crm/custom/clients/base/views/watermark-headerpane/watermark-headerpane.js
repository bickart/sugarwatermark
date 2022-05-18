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
    extendsFrom: 'HeaderpaneView',

    events: {
        'click [name=save_button]:not(".disabled")': 'initiateSave',
        'click a[name=cancel_button]': 'cancel'
    },

    productKey: null,

    initialize: function (options) {
        this._super('initialize', [options]);

        this.title = app.lang.get('LBL_WATERMARK_LICENSE_CONFIGURATION');
        this.context.on('watermark:toggle', this.toggleSendButton, this);
    },

    /**
     * Cancel and close the drawer
     */
    cancel: function () {
        app.router.navigate("#Administration", {trigger: true});
    },

    /**
     * Enable/disable the Save button
     *
     * @param enable true to enable, false to disable
     */
    toggleSendButton: function (enable) {
        this.$('[name=save_button]').toggleClass('disabled', !enable);
    },

    initiateSave: function () {
        this.context.trigger('watermark:save');
    }
})
