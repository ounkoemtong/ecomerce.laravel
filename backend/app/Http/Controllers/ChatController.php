<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\ProductModel;

class ChatController extends Controller
{
    public function chat(Request $request)
    {
        $messages = $request->input('messages');
        $groqToken = env('GROQ_API_KEY');

        if (empty($groqToken)) {
            return response()->json(['error' => 'Groq API Key is not configured on the backend.'], 500);
        }
        try {
            $dbProducts = ProductModel::get(['id', 'name', 'price', 'discount_price', 'description', 'image']);
            $productCatalog = "";
            foreach ($dbProducts as $product) {
                $displayPrice = $product->discount_price ? "$".$product->discount_price : "$".$product->price;
                $imageUrl = url($product->image);
                $productCatalog .= "- {$product->name} (Price: {$displayPrice}, Link: /product/{$product->id}, Image: {$imageUrl})\n";
            }
        } catch (\Exception $e) {
            $productCatalog = "- Warm winter coat (Price: $890, Link: /product/sculptural-wool-overcoat, Image: https://images.unsplash.com/photo-1591369822096-ffd140ec948f)\n";
        }
        
        $userName = $request->input('userName');
        $userGreeting = $userName ? "The user you are speaking to is named {$userName}. Address them by their name occasionally." : "";

        $systemPrompt = "You are a professional, high-end digital stylist for 'Atelier', a luxury fashion brand featuring quiet luxury, clean lines, and architectural tailoring. Answer the user politely, in character as an elegant personal stylist. {$userGreeting}

CRITICAL RULES:
1. Keep your answers EXTREMELY short and concise. Do NOT write paragraphs. Limit responses to 1 or 2 sentences maximum.
2. NEVER mention that you are an AI, a chatbot, or a large language model.
3. You MUST only recommend products that are actually available in our store catalog:
{$productCatalog}
4. When recommending products, ALWAYS provide a Markdown link wrapping the product image, like this: [![Product Name](Image URL)](/product/id). Do not output a separate text link.";

        $formattedMessages = array_merge([
            ['role' => 'system', 'content' => $systemPrompt]
        ], $messages);

        try {
            $response = Http::timeout(60)->withHeaders([
                'Authorization' => "Bearer $groqToken",
                'Content-Type' => 'application/json',
            ])->post('https://api.groq.com/openai/v1/chat/completions', [
                'model' => 'llama-3.1-8b-instant',
                'messages' => $formattedMessages,
                'max_tokens' => 250,
                'temperature' => 0.7
            ]);

            if ($response->failed()) {
                $errorVal = $response->json('error') ?? 'Request to Groq failed';
                $errorMsg = is_array($errorVal) ? json_encode($errorVal) : (string)$errorVal;
                
                return response()->json([
                    'error' => $errorMsg
                ], $response->status() ?: 500);
            }

            return response()->json($response->json());
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
