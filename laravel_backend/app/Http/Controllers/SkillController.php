<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Skill;
use App\Http\Requests\SkillStoreRequest;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
 
class SkillController extends Controller
{
    public function index()
    {
       // All Product
       $skills = Skill::all();
      
       // Return Json Response
       return response()->json([
          'skills' => $skills
       ],200);
    }
  
    public function store(SkillStoreRequest $request)
    {
        try {
            $imageName = Str::random(32).".".$request->image->getClientOriginalExtension();
      
            // Create Product
            Skill::create([
                'name' => $request->name,
                'image' => $imageName,
                'description' => $request->description
                
            ]);
      
            // Save Image in Storage folder
            Storage::disk('public')->put($imageName, file_get_contents($request->image));
      
            // Return Json Response
            return response()->json([
                'message' => "Skill successfully created."
            ],200);
        } catch (\Exception $e) {
            // Return Json Response
            return response()->json([
                'message' => "Something went really wrong!"
            ],500);
        }
    }
  
    public function show($id)
    {
       // Product Detail 
       $skills = Skill::find($id);
       if(!$skills){
         return response()->json([
            'message'=>'skills Not Found.'
         ],404);
       }
      
       // Return Json Response
       return response()->json([
          'skill' => $skills
       ],200);
    }
  
    public function update(SkillStoreRequest $request, $id)
    {
        try {
            // Find product
            $skill = Skill::find($id);
            if(!$skill){
              return response()->json([
                'message'=>'Skill Not Found.'
              ],404);
            }
      
            //echo "request : $request->image";
            $skill->name = $request->name;
            $skill->description = $request->description;
            
      
            if($request->image) {
 
                // Public storage
                $storage = Storage::disk('public');
      
                // Old iamge delete
                if($storage->exists($skill->image))
                    $storage->delete($skill->image);
      
                // Image name
                $imageName = Str::random(32).".".$request->image->getClientOriginalExtension();
                $skill->image = $imageName;
      
                // Image save in public folder
                $storage->put($imageName, file_get_contents($request->image));
            }
      
            // Update Product
            $skill->save();
      
            // Return Json Response
            return response()->json([
                'message' => "skill successfully updated."
            ],200);
        } catch (\Exception $e) {
            // Return Json Response
            return response()->json([
                'message' => "Something went really wrong!"
            ],500);
        }
    }
  
    public function destroy($id)
    {
        // Detail 
        $skill = Skill::find($id);
        if(!$skill){
          return response()->json([
             'message'=>'skill Not Found.'
          ],404);
        }
      
        // Public storage
        $storage = Storage::disk('public');
      
        // Iamge delete
        if($storage->exists($skill->image))
            $storage->delete($skill->image);
      
        // Delete Product
        $skill->delete();
      
        // Return Json Response
        return response()->json([
            'message' => "skill successfully deleted."
        ],200);
    }
}