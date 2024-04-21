<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \App\Models\Eleve;
use Illuminate\Support\Facades\Validator;


class EleveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $eleves = Eleve::all();
        if ($eleves->count() > 0) {
            return response([
                'status'=>200,
                'eleves' => $eleves
            ], 200);
    
        }else{
            return response([
                'status'=>404,
                'message' => "Aucun élève n'a été trouvé"
            ], 404);
        }   
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'grade' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:eleves',
            'phone' => 'required|digits:10',
        ]);
        if($validator->fails())
        {
            return response()->json([
                'status' => 422, 
                'errors' => $validator->messages()
            ], 422);
        }else
        {
            $eleve = Eleve::create([
                'name' => $request->name,
                'grade' => $request->grade,
                'email' => $request->email,
                'phone' => $request->phone,
            ]);
            if($eleve)
            {
                return response()->json([
                    'status' => 200,
                    'message' => "L'élève a été ajouté avec succès"
                ], 200);
            }else
            {
                return response()->json([
                    'status' => 500,
                    'message' => "Une erreur est survenue"
                ], 500);
            }
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $eleve = Eleve::find($id);
        if ($eleve) 
        {
            return response()->json([
                'status' => 200, 
                'eleve' => $eleve
            ], 200);
        }else
        {
            return response()->json([
                'status'=>404,
                'message' => "Aucun élève n'a été trouvé"
            ], 404);
        }
        
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $eleve = Eleve::find($id);
        if ($eleve) 
        {
            return response()->json([
                'status' => 200, 
                'eleve' => $eleve
            ], 200);
        }else
        {
            return response()->json([
                'status'=>404,
                'message' => "Aucun élève n'a été trouvé"
            ], 404);
        }
    }


    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'grade' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:eleves',
            'phone' => 'required|digits:10',
        ]);
        if($validator->fails())
        {
            return response()->json([
                'status' => 422, 
                'errors' => $validator->messages()
            ], 422);
        }else
        {
            $eleve = Eleve::find($id);
            
            if($eleve)
            {
                $eleve->update([
                    'name' => $request->name,
                    'grade' => $request->grade,
                    'email' => $request->email,
                    'phone' => $request->phone,
                ]);
                return response()->json([
                    'status' => 200,
                    'message' => "L'élève a été mis à jour avec succès"
                ], 200);
            }else
            {
                return response()->json([
                    'status' => 404,
                    'message' => "Aucun élève n'a été trouvé"
                ], 404);
            }
        }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $eleve = Eleve::find($id);
        if($eleve)
        {
            $eleve->delete();
            return response()->json([
                'status' => 200,
                'message' => " L'élève a été supprimé avec succès"
            ], 200);

        }else
        {
            return response()->json([
                'status' => 404,
                'message' => "Aucun élève n'a été trouvé"
            ], 404);

        }
        
    }
}
