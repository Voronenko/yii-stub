<?php
interface IPageService
{
	/**
	 * Returns the data model based on the alias.
	 * @param string $alias the alias of the model to be loaded
	 * @return $model data model
	 */
    public static function getPageByAlias($alias);
    
	/**
	 * Returns the data model based on the ID.
	 * @param integer $id the ID of the model to be loaded
	 * @return $model data model
	 */
    public static function getPageById($id);
    
    
	/**
	 * Returns the data model
	 * @return $model data model
	 */
    //TODO
	public static function getPageModel();
    
    
	/**
	 * Creates the data model based on $_POST parameters
	 * @param array $pagePost the $_POST data from form
	 */
	public static function createPage($pagePost);
	
	
	/**
	 * Edits the data model based on $_POST parameters
	 * @param integer $id the ID of model to be edited
	 * @param array $pagePost the $_POST data from form
	 */
	public static function editPage($id, $pagePost);
	
	/**
	 * Deletes the data model based on ID parameter
	 * @param integer $id the ID of the model to be deleted
	 */
    public static function deletePageById($id);
}
