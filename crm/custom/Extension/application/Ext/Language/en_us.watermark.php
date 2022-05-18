<?php
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
$app_strings['LBL_WATERMARK_LICENSE_CONFIGURATION'] = 'Watermark Configuration';
$app_strings['LBL_WATERMARK_TEXT_PLACEHOLDER'] = 'Watermark';
$app_strings['LBL_WATERMARK_SAVED'] = 'Watermark Saved';
$app_strings['WATERMARK_CSS'] = 'html:after {
    /* common custom values */
    content: "{0}"; /* your site name */
    font-size: {1}; /* font size */
    color: rgba(0, 0, 50, .1);
    /* alpha, could be even rgba(0,0,0,.05) */

    /* rest of the logic */
    z-index: 9999;
    cursor: default;
    display: block;
    position: fixed;
    top: 33%;
    right: 0;
    bottom: 0;
    left: 15%;
    font-family: sans-serif;
    font-weight: bold;
    font-style: italic;
    text-align: center;
    line-height: 100%;

    /* not sure about who implemented what ..
 *       ... so bring it all */
    -webkit-pointer-events: none;
    -moz-pointer-events: none;
    -ms-pointer-events: none;
    -o-pointer-events: none;
    pointer-events: none;

    -webkit-transform: rotate(-40deg);
    -moz-transform: rotate(-40deg);
    -ms-transform: rotate(-40deg);
    -o-transform: rotate(-40deg);
    transform: rotate(-40deg);

    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    -o-user-select: none;
    user-select: none;
}';