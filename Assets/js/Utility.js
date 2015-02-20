/**
 * Utility namespace
 */
Amarkal.Utility = function() {};



/**
 * Replace an array of patterns.
 * NOTE: Order DOES matter!
 * 
 * @param {array} patterns An array of 2 element arrays of [ pattern, replacement ]
 * @param {string} string
 * @returns {string} reformatted string
 */
Amarkal.Utility.arrayReplace = function( patterns, string )
{
   var result = string;
   for( var i = 0; i < patterns.length; i++ )
   {
       result = result.replace( patterns[i][0], patterns[i][1] );
   }
   return result;
};

/**
 * Merge the contents of two objects together into a single object, overwriting
 * the properties of the first objects with those of the second.
 * 
 * Note: This function preserves both original objects.
 * 
 * @param {Object} obj1
 * @param {Object} obj2
 * @returns {Object}
 */
Amarkal.Utility.extend = function( obj1, obj2 )
{
    return $.extend({}, obj1, obj2);
};