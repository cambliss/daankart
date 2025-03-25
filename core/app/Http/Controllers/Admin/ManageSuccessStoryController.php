<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Frontend;
use App\Models\SuccessStory;
use App\Rules\FileTypeValidate;
use Illuminate\Http\Request;
use App\Models\StoryComment;
use Exception;

class ManageSuccessStoryController extends Controller
{
    public function index()
    {
        $pageTitle      = "Success Stories";
        $successStories = SuccessStory::searchable(['title', 'category:name'])->with('category')->orderBy('id', 'DESC')->paginate(getPaginate());
        return view('admin.story.index', compact('pageTitle', 'successStories'));
    }

    public function create()
    {
        $pageTitle = "Create Success Story";
        $categories = Category::active()->orderBy('name')->get();
        return view('admin.story.form', compact('pageTitle', 'categories'));
    }

    public function store(Request $request, $id = 0)
    {
        $request->validate([
            'image'             => ['sometimes', new FileTypeValidate(['jpg', 'jpeg', 'png'])],
            'category'          => 'required|integer|exists:categories,id',
            'title'             => 'required|min:5|max:300',
            'description'       => 'required',
        ]);
        if ($id) {
            $story           = SuccessStory::findOrFail($id);
            $notification    = 'Success story updated successfully';
        } else {
            $story           = new SuccessStory();
            $notification    = 'Success story added successfully';
        }


        if ($request->hasFile('image')) {
            try {
                $old = @$story->image;
                $story->image = fileUploader($request->image, getFilePath('success'), getFileSize('success'), $old);
            } catch (\Exception $exp) {
                $notify[] = ['error', 'Couldn\'t upload success story image'];
                return back()->withNotify($notify);
            }
        }

        $story->title             = $request->title;
        $story->category_id       = $request->category;
        $story->description       = $request->description;
        $story->slug              = slug($request->title);
        $story->save();
        $notify[] = ['success', $notification];
        return back()->withNotify($notify);
    }

    public function edit($id)
    {
        $pageTitle  = "Edit Success Story";
        $categories = Category::active()->orderBy('name')->get();
        $story      = SuccessStory::findOrFail($id);
        return view('admin.story.form', compact('pageTitle', 'categories', 'story'));
    }

    public function delete($id)
    {
        $story = SuccessStory::findOrFail($id);
        $comments = StoryComment::where('success_story_id', $id)->get();

        try {
            $path = getFilePath('success') . '/' . $story->image;
            $story->delete();
            if (@$comments) {
                foreach (@$comments as  $comment) {
                    $comment->delete();
                }
            }

            fileManager()->removeFile($path);

        } catch (Exception $ex) {
            $notify[] = ['error', $ex->getMessage()];
            return back()->withNotify($notify);
        }

        $notify[] = ['success', 'Story deleted Successfully'];
        return back()->withNotify($notify);
    }

    public function detail($id)
    {
        $pageTitle = "Success Story Details";
        $story    = SuccessStory::with('category')->with('comment')->findOrFail($id);
        return view('admin.story.detail', compact('pageTitle', 'story'));
    }

    public function comment()
    {
        $pageTitle     = "Success Story Reviews";
        $storyComments = StoryComment::searchable(['comment', 'reviewer', 'email', 'story:title'])->with('story')->whereHas('story')->orderBy('id', 'DESC')->paginate(getPaginate());
        return view('admin.story.comment', compact('pageTitle', 'storyComments'));
    }

    public function frontendSeo($id)
    {
        $data = SuccessStory::findOrFail($id);
        $pageTitle = 'SEO Configuration';
        return view('admin.story.frontend_seo', compact('pageTitle','data'));
    }



    public function frontendSeoUpdate(Request $request,$id){

        $request->validate([
            'image'=>['nullable',new FileTypeValidate(['jpeg', 'jpg', 'png'])]
        ]);
       
        $data = SuccessStory::findOrFail($id);
        $image = @$data->seo_content->image;
        if ($request->hasFile('image')) {
            try {
                $path = 'assets/images/frontend/success_story'.'/seo';
                $image = fileUploader($request->image,$path, getFileSize('seo'), @$data->seo_content->image);
            } catch (\Exception $exp) {
                $notify[] = ['error', 'Couldn\'t upload the image'];
                return back()->withNotify($notify);
            }
        }
        $data->seo_content = [
            'image'=>$image,
            'description'=>$request->description,
            'social_title'=>$request->social_title,
            'social_description'=>$request->social_description,
            'keywords'=>$request->keywords ,
        ];
        $data->save();

        $notify[] = ['success', 'SEO content updated successfully'];
        return back()->withNotify($notify);

    }


    public function commentStatus($id)
    {
        return StoryComment::changeStatus($id);
    }
}
