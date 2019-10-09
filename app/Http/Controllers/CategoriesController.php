<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Category;
use App\Subcategory;
use App\Job;
use App\UserProfile;
use App\Blog;

class CategoriesController extends Controller
{
    public function categoriesAll(){
        return view('categories')->with('categories', Category::all());
    }

    public function categoriesAllJson(){
        return response()->json(Category::all()->take(4)->map(function($category){
            return [
                'id' => $category->id,
                'name' => $category->name,
                'description' => $category->description,
                'image' => $category->getCategoryImage(),
                'subcategories' => count($category->subcategories),
                'profiles' => count($category->profiles),
                'jobs' => '0'
            ];
        }));
    }

    public function category($id){
        $data = array(
            'category' => Category::findOrFail($id),
            'subcategories' => Subcategory::where('category_id', $id)->get()
        );
        return view('category.category')->with($data);
    }

    public function subcategoriesAll(Request $request, $id){
        $type = $request->input('type');
        $subcat = $request->input('subcat');
        $category = Category::findOrFail($id);

        if($type == 's'){

            $services = ($subcat == 'all') ? Job::whereHas('preferences', function($query) use ($category){
                 $query->where('category_id', $category->id);
            })->where('job_type', 'service')->get() : Job::whereHas('preferences', function($query) use ($subcat, $category){
                $query->where('category_id', $category->id)->where('subcategory_id', $subcat);
            })->where('job_type', 'service')->get();

            return view('job.services')->with('services', $services);

        } else if($type == 'j'){

            $jobs = ($subcat == 'all') ? Job::whereHas('preferences', function($query) use ($category){
                 $query->where('category_id', $category->id);
            })->where('job_type', 'job')->get() : Job::whereHas('preferences', function($query) use ($subcat, $category){
                $query->where('category_id', $category->id)->where('subcategory_id', $subcat);
            })->where('job_type', 'job')->get();

            return view('job.jobs')->with('jobs', $jobs);

        } else if($type == 'p'){

            $profiles = ($subcat == 'all') ? UserProfile::whereHas('preferences', function($query) use ($category){
                $query->where('category_id', $category->id);
            })->get() : UserProfile::whereHas('preferences', function($query) use ($subcat, $category){
                $query->where('category_id', $category->id)->where('subcategory_id', $subcat);
            })->get();

            return view('profile.profiles')->with('profiles', $profiles);
        
        } else if($type == 'b'){

            $blogs = ($subcat == 'all') ? Blog::whereHas('preferences', function($query) use ($category){
                $query->where('category_id', $category->id);
            })->get() : Blog::whereHas('preferences', function($query) use ($subcat, $category){
                $query->where('category_id', $category->id)->where('subcategory_id', $subcat);
            })->get();

            return view('blog.blogs')->with('blogs', $blogs);
            
        } else {
            return response('<p class="hd-error">UNKNOWN TYPE</p>');
        }
    }

    public function subcategory($cat, $id){
        $category = Category::findOrFail($cat);
        $subcategory = Subcategory::findOrFail($id);
        $jobs = Job::whereHas('preferences', function($query) use ($subcategory, $category){
                    $query->where('category_id', $category->id)->where('subcategory_id', $subcategory->id);
                })->where('job_type', 'job')->get();
        $services = Job::whereHas('preferences', function($query) use ($subcategory, $category){
                        $query->where('category_id', $category->id)->where('subcategory_id', $subcategory->id);
                    })->where('job_type', 'service')->get();
        $profiles = UserProfile::whereHas('preferences', function($query) use ($subcategory, $category){
                        $query->where('category_id', $category->id)->where('subcategory_id', $subcategory->id);
                    })->get();
        $blogs = Blog::whereHas('preferences', function($query) use ($subcategory, $category){
                        $query->where('category_id', $category->id)->where('subcategory_id', $subcategory->id);
                    })->get();

        $data = array(
            'category' => $category,
            'subcategory' => $subcategory,
            'jobs' => $jobs,
            'services' => $services,
            'profiles' => $profiles,
            'blogs' => $blogs
        );
        return view('category.subcategory')->with($data);
    }

    public function categoriesFilterJson(Request $request){
        return response()->json(Category::where('name', 'LIKE', '%' . $request->input('query') . '%')->take(4)->get()->map(function($category){
            return [
                'id' => $category->id,
                'name' => $category->name,
                'description' => $category->description,
                'image' => $category->getCategoryImage(),
                'subcategories' => count($category->subcategories),
                'profiles' => count($category->profiles),
                'jobs' => '0'
            ];
        }));
    }

    public function subcategoriesFilterJson(Request $request, $id){
        return response()->json(Subcategory::where('category_id', $id)->where('name', 'LIKE', '%' . $request->input('query') . '%')->get()->map(function($subcat){
            return [
                'id' => $subcat->id,
                'name' => $subcat->name,
                'description' => $subcat->description,
                'icon' => $subcat->getIcon(),
                'profiles' => count($subcat->profiles),
                'jobs' => 0
            ];
        }));
    }
}
