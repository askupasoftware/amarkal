<?php

namespace Amarkal\UI;

/**
 * Exception thrown if component/field is instantiated without a required parameter.
 * 
 * The required parameters are defined on a per component/field basis.
 * 
 * @see ComponentInterface::required_settings()
 * @see FieldInterface::required_settings()
 */
class RequiredParameterException extends \RuntimeException { }
