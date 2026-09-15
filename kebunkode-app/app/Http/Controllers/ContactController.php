<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'message' => 'required|string|max:2000',
            'product_id' => 'nullable|exists:products,id',
            'source' => 'nullable|string|max:50',
        ]);

        Message::create([
            'name' => $validated['name'],
            'phone' => $validated['phone'],
            'message' => $validated['message'],
            'product_id' => $validated['product_id'] ?? null,
            'source' => $validated['source'] ?? 'landing',
            'is_read' => false,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Pesan berhasil dikirim. Kami akan segera menghubungi Anda.',
        ]);
    }
}
