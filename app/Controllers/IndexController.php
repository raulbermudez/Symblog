<?php

namespace App\Controllers;

use App\Models\Blog;
use App\Models\Comment;

class IndexController extends BaseController
{
    public function indexAction()
    {
        $blogs = Blog::with('comments')->orderBy('created_at', 'desc')->get();
    
        return $this->renderHTML('index_view.twig', [
            'blogs' => $blogs, "user" => $_SESSION['perfil']
        ]);
    }
    
    public function aboutAction()
    {
        $tags = Blog::getAllTags();
        return $this->renderHTML('about.twig', ['tags' => $tags, "user" => $_SESSION['perfil']]);
    }

    public function adminAction()
    {
        $tags = Blog::getAllTags();
        return $this->renderHTML('admin.twig', ['tags' => $tags]);
    }
}
