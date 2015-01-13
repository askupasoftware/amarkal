<?php

namespace Amarkal\Extensions\WordPress\Widget;

/**
 * Exception thrown if component is instantiated without a required parameter.
 * 
 * The required parameters are defined on a per-component basis.
 * 
 * @see ComponentInterface::required_settings()
 */
class RequiredParameterException extends \RuntimeException { }
