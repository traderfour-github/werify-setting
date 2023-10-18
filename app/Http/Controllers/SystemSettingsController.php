<?php

namespace App\Http\Controllers;

use App\Jobs\SettingSingleJob;
use App\Jobs\SettingUpdateJob;
use App\Repositories\SettingsRepositoryInterface;
use Illuminate\Http\Request;

/**
 * Class SettingItemViewModel
 *
 * @property string $title
 * @property string $body
 * @package App\ViewModels
 * @OA\Schema(
 *     schema="SettingItemRequest",
 *     type="object",
 *     title="SettingItemRequest",
 *     required={"key", "data"},
 *     properties={
 *         @OA\Property(property="key", type="string"),
 *         @OA\Property(property="data", type="array", @OA\Items({
 *
 *         })),
 *     }
 * )
 */

/**
 * @OA\Schema(
 *     schema="SettingItemResponse",
 *     type="object",
 *     title="SettingItemResponse",
 *     properties={
 *     }
 * )
 */
class SystemSettingsController extends Controller
{
	var $settingRepository;

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct( SettingsRepositoryInterface $settingRepository )
	{
		$this->settingRepository = $settingRepository;
	}

	public function index()
	{
		return [];
	}

	/**
	 * @OA\Post(
	 *     path="/posts",
	 *     summary="New blog post",
	 *     operationId="store",
	 *     tags={"Post"},
	 *     @OA\RequestBody(
	 *         required=true,
	 *         description="Post object",
	 *         @OA\JsonContent(ref="#/components/schemas/SettingItemRequest")
	 *     ),
	 *     @OA\Response(
	 *         response=200,
	 *         description="setting value",
	 *         @OA\JsonContent(ref="#/components/schemas/SettingItemResponse"),
	 *     ),
	 *     @OA\Response(
	 *         response="default",
	 *         description="unexpected error",
	 *         @OA\Schema(ref="#/components/schemas/Error")
	 *     )
	 * )
	 * @param Request $request
	 *
	 * @return array
	 */
	public function store( Request $request )
	{
		$data = $this->validate
		(
			$request,
			[
				'key'  => 'required|string',
				'data' => 'required',
			]
		);
		return dispatch_now( new SettingUpdateJob( $data[ 'key' ], $data[ 'data' ] ) );
	}

	/**
	 * update/create a setting item.
	 * @OA\Get(
	 *     path="/api/system/{key}",
	 *     description="update/create a setting model.",
	 *     @OA\Parameter(
	 *       description="setting model key",
	 *       in="path",
	 *       name="model",
	 *       required=true,
	 *       example="version",
	 *    ),
	 *     @OA\Response(
	 *         response=200,
	 *         description="setting value",
	 *         @OA\JsonContent(ref="#/components/schemas/SettingItemResponse"),
	 *     ),
	 *     @OA\Response(
	 *         response="default",
	 *         description="unexpected error",
	 *         @OA\Schema(ref="#/components/schemas/Error")
	 *     )
	 * )
	 */
	public function single( $key, Request $request )
	{
		return dispatch_now( new SettingSingleJob( $key ) );
	}

	/**
	 * update/create a setting item.
	 * @OA\Get(
	 *     path="/api/system/{key}",
	 *     description="update/create a setting item.",
	 *     @OA\Parameter(
	 *       description="setting model key",
	 *       in="path",
	 *       name="model",
	 *       required=true,
	 *       example="version",
	 *    ),
	 * 	   @OA\Parameter(
	 *       description="setting items key",
	 *       in="path",
	 *       name="items",
	 *       required=true,
	 *       example="version",
	 *    ),
	 * @OA\Response(
	 *         response=200,
	 *         description="setting value",
	 *         @OA\JsonContent(ref="#/components/schemas/SettingItemResponse"),
	 *     ),
	 * @OA\Response(
	 *         response="default",
	 *         description="unexpected error",
	 *         @OA\Schema(ref="#/components/schemas/Error")
	 *     )
	 * )
	 */
	public function singleItem( $key, $items, Request $request )
	{
		return dispatch_now( new SettingSingleJob( $key, str_replace( ',', '.', $items ) ) );
	}
	//
}
