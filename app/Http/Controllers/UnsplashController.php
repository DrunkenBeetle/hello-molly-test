<?php

namespace App\Http\Controllers;

use App\Models\Unsplash as UnsplashModel;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UnsplashController extends Controller
{
    /**
     * Query the Unsplash API
     *
     * Methid will query the Unsplash API and return the first page of results
     *
     * @access private
     * @param string The search term to search for
     * @return array An array of items
     */
    private function searchUnsplash($searchTerm) {
        $filtered = [];
        $results = \Unsplash::search()
            ->term($searchTerm)
            ->orientation('portrait')
            ->toJson();

        /**
         * We just get the first page of results
         */
        if ($results->total > 0) {
            foreach ($results->results as $result) {
                $filtered[] = [
                    'unsplash_api_id' => $result->id,
                    'description' => trim($result->description ? $result->description : ''),
                    'full_url' => $result->urls->full,
                    'thumbnail_url' => $result->urls->thumb,
                ];
            }
        }

        return $filtered;
    }

    /**
     * Get the search results
     *
     * Method will get the stored Unsplash results based on the search term. If there is no search term
     * record in the DB then will create a new one with search results. Also, if there is an existing term
     * BUT is stale (1 day), then record will be removed and "re-cached" from unsplash
     *
     * @access public
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request) {
        $search = trim(mb_strtolower($request->search));

        if ($search === '') {
            return response()->json([]);
        }

        $unsplash = UnsplashModel::where('search_term', $search)->first();

        /**
         * Check if its stale (order than one day for now). If so then remove it and 're-cache' from unsplash api
         */
        if ($unsplash && date_diff(date_create($unsplash->created_at), date_create('now'))->d > 0) {
            $unsplash->delete();
            $unsplash = null;
        }

        if (!$unsplash) {
            $unsplash = UnsplashModel::create([
                'search_term' => $search,
            ]);

            $results = $this->searchUnsplash($search);

            if (count($results) > 0) {
                $unsplash->items()->createMany($results);
            }
        }

        return response()->json($unsplash->items);
    }
}
