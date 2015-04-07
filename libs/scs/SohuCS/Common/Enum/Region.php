<?php
/**
 * Copyright 2010-2013 Amazon.com, Inc. or its affiliates. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License").
 * You may not use this file except in compliance with the License.
 * A copy of the License is located at
 *
 * http://aws.amazon.com/apache2.0
 *
 * or in the "license" file accompanying this file. This file is distributed
 * on an "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either
 * express or implied. See the License for the specific language governing
 * permissions and limitations under the License.
 */

namespace SohuCS\Common\Enum;

use SohuCS\Common\Enum;

/**
 * Contains enumerable region code values. These should be useful in most cases,
 * with Amazon S3 being the most notable exception
 *
 * @link http://docs.aws.amazon.com/general/latest/gr/rande.html AWS Regions and Endpoints
 */
class Region extends Enum
{
    const BJCNC		= 'bjcnc';
    const BJCTC		= 'bjctc';
    const SHCTC		= 'shctc';
}