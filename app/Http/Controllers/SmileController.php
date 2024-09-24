<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SmileController extends Controller
{
    public function detectSmile(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Resmi kaydetme
        $path = $request->file('image')->store('images', 'public');

        // Gülümseme tespiti için FastAPI'ye istek gönderme
        $client = new Client();
        $response = $client->post('http://127.0.0.1:8085/detect_smile/', [
            'multipart' => [
                [
                    'name' => 'file',
                    'contents' => fopen(storage_path('app/public/' . $path), 'r'),
                    'file' => $request->file('image')->getClientOriginalName(),
                ],
            ],
        ]);

        $result = json_decode($response->getBody()->getContents(), true);

        // Gülümseme sonucunu veritabanına kaydetme
        $smile = Smile::create([
            'user_id' => auth()->id(),
            'image_path' => $path,
            'smile_detected' => $result['smile_detected'],
        ]);

        return response()->json($smile);
    }
}
