/*
 * MIT License
 *
 * Copyright (c) 2022 Jeff Bickart
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
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
    extendsFrom: 'BaseLayout',
    initialize: function () {

        if (app.config.hasOwnProperty('watermark')) {
            if (! _.isEmpty(app.config.watermark)) {
                let content = app.config.watermark;
                let font_size = '225px';

                if (app.config.watermark.length > 12) {
                    font_size = '100px';
                } else if (app.config.watermark.length > 6) {
                    font_size = '150px';
                }

                // noinspection HtmlDeprecatedAttribute
                $('head').append('<style type="text/css">' + app.lang.get("WATERMARK_CSS").replace('{0}', content).replace('{1}', font_size) + '</style>');
            }
        }

        this._super('initialize', arguments);
    }
})