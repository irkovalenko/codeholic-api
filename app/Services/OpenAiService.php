<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use OpenAI\Factory;

class OpenAiService
{
    /**
     * Create a new class instance.
     */
    public function generatePromptFromImage(UploadedFile $image): string
    {
        $imageData =  base64_encode(file_get_contents($image->getPathname()));
        $mimeType = $image->getMimeType();

        $client = (new Factory()->withApiKey(config('services.openai.api_key')))->make();
        $response = $client->chat()->create([
            'model' => 'gpt-4o',
            'messages' => [
                [
                    'role' => 'user',
                    'content' => [
                        [
                            'type' => 'text',
                            'text' =>
                            'Analyze this image and generate a detailed, descriptive prompt
                            that could be used to recreate the image using an AI image generation model.
                            Focus on describing the key elements, composition, colors, and style of the image.
                            You MUST preserve ascpet ratio exactly as the original image has or very close
                            to it.',
                        ],
                        [
                            'type' => 'image_url',
                            'image_url' => [
                                'url' => 'data:' . $mimeType . ';base64,' . $imageData
                            ]
                        ]
                    ]
                ]

            ]
        ]);
        return $response->choices[0]->message->content;
    }
}
