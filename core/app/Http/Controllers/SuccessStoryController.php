<?php

namespace App\Http\Controllers;

use App\Models\StoryComment;
use App\Models\Category;
use App\Models\Page;
use App\Models\SuccessStory;
use Illuminate\Http\Request;

class SuccessStoryController extends Controller
{
    public function index()
    {
        $pageTitle  = 'Success Stories';
        $categories = Category::active()->whereHas('stories')->get();
        $stories    = SuccessStory::searchable(['title'])->orderBy('id', 'DESC')->with('category')->customFilter(request(['month', 'year', 'category_id']))->paginate(getPaginate());
        if (request()->slug) {
            $category = Category::where('slug', request()->slug)->firstOrFail();
            $stories  = $category->stories()->searchable(['title'])->orderBy('id', 'DESC')->with('category')->customFilter(request(['month', 'year', 'category_id']))->paginate(getPaginate());
        }
        $archives = SuccessStory::selectRaw('year(created_at) year, monthname(created_at) month, count(*)')->groupBy('year', 'month')->get();
        $sections    = Page::where('tempname', activeTemplate())->where('slug', 'success-story')->first();
        $seoContents = @$sections->seo_content;
        $seoImage    = @$seoContents->image ? getImage(getFilePath('seo') . '/' . @$seoContents->image, getFileSize('seo')) : null;
        return view('Template::success_story.index', compact('pageTitle', 'stories', 'categories', 'archives', 'sections', 'seoContents', 'seoImage'));
    }


    public function details($slug, $id)
    {
        $pageTitle = 'Success Story Details';

        $story        = SuccessStory::where('slug', $slug)->findOrFail($id);
        $story->view += 1;
        $story->save();

        $categories    = Category::active()->whereHas('stories')->get();
        $archives      = SuccessStory::selectRaw('year(created_at) Year, monthname(created_at) Month , count(*)')->groupBy('year', 'month')->get();
        $recentStories = SuccessStory::where('id', '!=', $id)->orderBy('id', 'DESC')->take(4)->get();
        $comments      = StoryComment::where('success_story_id', $id)->published()->orderBy('id', 'DESC')->get();

        $seoContents = $story->seo_content;
        $seoImage    = @$seoContents->image ? frontendImage('success_story', $seoContents->image, getFileSize('seo'), true) : null;

        return view('Template::success_story.details', compact('pageTitle', 'story', 'categories', 'archives', 'recentStories', 'comments', 'seoContents', 'seoImage'));
    }


    public function comment(Request $request, $storyId)
    {
        $story = SuccessStory::findOrFail($storyId);
        $request->validate([
            'name'    => 'required|min:3|max:40',
            'email'   => 'required|email|max:40',
            'comment' => 'string|required|max:400',
        ]);
        $comment                   = new StoryComment();
        $comment->success_story_id = $story->id;
        $comment->commenter        = $request->name;
        $comment->email            = $request->email;
        $comment->comment          = $request->comment;
        $comment->save();
        $notify[] = ['success', 'Comment saved successfully, Please wait for admin approval!'];
        return back()->withNotify($notify)->withInput();
    }
}
