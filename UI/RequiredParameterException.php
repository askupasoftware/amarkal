<?php

namespace Amarkal\UI;

/**
 * Exception thrown if a field is instantiated without a required parameter.
 * 
 * The required parameters are defined on a per-field basis.
 * 
 * @see FieldInterface::required_parameters()
 */
class RequiredParameterException extends \RuntimeException { }
