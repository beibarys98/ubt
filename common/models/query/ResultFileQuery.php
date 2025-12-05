<?php

namespace common\models\query;

/**
 * This is the ActiveQuery class for [[\common\models\ResultFile]].
 *
 * @see \common\models\ResultFile
 */
class ResultFileQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \common\models\ResultFile[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\ResultFile|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
