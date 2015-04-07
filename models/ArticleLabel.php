<?php

class ArticleLabel extends BaseModel
{

    /**
     *
     * @var integer
     */
    protected $articleId;

    /**
     *
     * @var integer
     */
    protected $cityId;

    /**
     *
     * @var integer
     */
    protected $articleType;

    /**
     *
     * @var integer
     */
    protected $labelId;

    /**
     *
     * @var integer
     */
    protected $labelType;

    /**
     * Method to set the value of field articleId
     *
     * @param integer $articleId
     * @return $this
     */
    public function setArticleid($articleId)
    {
        $this->articleId = $articleId;

        return $this;
    }

    /**
     * Method to set the value of field cityId
     *
     * @param integer $cityId
     * @return $this
     */
    public function setCityid($cityId)
    {
        $this->cityId = $cityId;

        return $this;
    }

    /**
     * Method to set the value of field articleType
     *
     * @param integer $articleType
     * @return $this
     */
    public function setArticletype($articleType)
    {
        $this->articleType = $articleType;

        return $this;
    }

    /**
     * Method to set the value of field labelId
     *
     * @param integer $labelId
     * @return $this
     */
    public function setLabelid($labelId)
    {
        $this->labelId = $labelId;

        return $this;
    }

    /**
     * Method to set the value of field labelType
     *
     * @param integer $labelType
     * @return $this
     */
    public function setLabeltype($labelType)
    {
        $this->labelType = $labelType;

        return $this;
    }

    /**
     * Returns the value of field articleId
     *
     * @return integer
     */
    public function getArticleid()
    {
        return $this->articleId;
    }

    /**
     * Returns the value of field cityId
     *
     * @return integer
     */
    public function getCityid()
    {
        return $this->cityId;
    }

    /**
     * Returns the value of field articleType
     *
     * @return integer
     */
    public function getArticletype()
    {
        return $this->articleType;
    }

    /**
     * Returns the value of field labelId
     *
     * @return integer
     */
    public function getLabelid()
    {
        return $this->labelId;
    }

    /**
     * Returns the value of field labelType
     *
     * @return integer
     */
    public function getLabeltype()
    {
        return $this->labelType;
    }

    /**
     * @return ArticleLabel[]
     */
    public static function find($parameters = array())
    {
        return parent::find($parameters);
    }

    /**
     * @return ArticleLabel
     */
    public static function findFirst($parameters = array())
    {
        return parent::findFirst($parameters);
    }

    /**
     * Independent Column Mapping.
     */
    public function columnMap()
    {
        return array(
            'articleId' => 'articleId', 
            'cityId' => 'cityId', 
            'articleType' => 'articleType', 
            'labelId' => 'labelId', 
            'labelType' => 'labelType'
        );
    }

}
