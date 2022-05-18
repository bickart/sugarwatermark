<?php
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

use Psr\SimpleCache\CacheInterface;
use Sugarcrm\Sugarcrm\DependencyInjection\Container;

class WatermarkApi extends SugarApi
{
    public function registerApiRest()
    {
        return array(
            'watermark' => array(
                'reqType' => 'PUT',
                'path' => array('watermark'),
                'pathVars' => array('watermark'),
                'method' => 'setWatermark',
                'shortHelp' => 'Sets the watermark sugar_config variable',
            )
        );
    }

    /**
     * Get the value of a the $sugar_config
     *
     * @param ServiceBase $api
     * @param array $args
     * @return mixed
     * @throws SugarApiExceptionMissingParameter
     */
    public function setWatermark(ServiceBase $api, array $args)
    {
        $this->requireArgs($args, array('watermark_code'));

        global $sugar_config;

        unset($sugar_config['additional_js_config']['watermark']);

        $configurator = new \Configurator();
        $configurator->config['additional_js_config']['watermark'] = trim($args['watermark_code']);
        $configurator->handleOverride();

        $repair = new RepairAndClear();
        $repair->repairBaseConfig();
//        $repair->repairAndClearAll(array('repairConfigs'), array(translate('LBL_ALL_MODULES')), false, false, '');

        $data = [
            'ok' => true,
            'watermark_code' => $sugar_config['additional_js_config']['watermark']
        ];
        return $data;

    }

}