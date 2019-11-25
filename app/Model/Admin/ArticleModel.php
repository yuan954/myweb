<?php

namespace App\Model\Admin;

use Illuminate\Database\Eloquent\Model;

class ArticleModel extends Base
{
    protected $table = 'article';
    protected $primaryKey = 'art_id';
    public $timestamps = true;

    public function saveArticle($params)
    {
        $res = $this->saveData($params);

        return $res;
    }
}
