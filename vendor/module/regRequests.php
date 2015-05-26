<?php
/**
 * Description of regRequests
 *
 * @author Broff
 */
class regRequests extends Module
{
	//
	//return void
	//
	public function __construct()
	{
		$this->SetGetFunctions();
		$this->SetPostFunctions();
	}
	//
	//return new Response()
	//
	public function RunModuleFunction($functionType, $functionName,  $functionArgs,  $accessLevel)
	{
		$functionName = strtolower($functionName);
		$functionType = strtolower($functionType);
		Dish::$_accessLevel = $accessLevel;
		$outputData = function($args)
		{
			$response = new Response();
			$response->SetStatusCode(400, 'Not found, or low access level');
			return $response;
		};

		switch($functionType)
		{
			case "get":
				foreach($this->_getFunctionsList as $functionData)
				{
					if($functionData['access'] <= $accessLevel && $functionData['name'] == $functionName)
					{
						$outputData = $functionData['function'];
						break;
					}
				}
			break;
			case "post":
				foreach($this->_postFunctionsList as $functionData)
				{
					if($functionData['access'] <= $accessLevel && $functionData['name'] == $functionName)
					{
						$outputData = $functionData['function'];
						break;
					}
				}
			break;
		}

		return $outputData($functionArgs);
	}
	//
	//
	//
	public function SetGetFunctions()
	{

		$this->get('list', 3, function($args)
		{
			$response = new Response();
			$parametersArray = array(
                            'limit' => 'int',
                            'offset' => 'int'
			);
			if(Module::CheckArgs($parametersArray, $args))
			{
				$model = new regRequestsModel();
				$limit = $args['limit'];
                                $offset = $args['offset'];
				$searchList = $model->PrivateList($limit, $offset);
				if($searchList!=null)
				{
					$response->SetJsonContent($searchList);
					$response->SetStatusCode(200, 'OK');
				}
				else
				{
					$response->SetStatusCode(204, 'Not founded requests');
				}
			}
			else
			{
				$response->SetStatusCode(400, 'Arguments not found(limit[int], offset[int]) or Incorrect arguments type');
			}

			return $response;
		});
                
                $this->get('fullList', 3, function($args)
		{
			$response = new Response();
			$parametersArray = array(
                            'limit' => 'int',
                            'offset' => 'int'
			);
			if(Module::CheckArgs($parametersArray, $args))
			{
				$model = new regRequestsModel();
				$limit = $args['limit'];
                                $offset = $args['offset'];
				$searchList = $model->PrivateFullList($limit, $offset);
				if($searchList!=null)
				{
					$response->SetJsonContent($searchList);
					$response->SetStatusCode(200, 'OK');
				}
				else
				{
					$response->SetStatusCode(204, 'Not founded requests');
				}
			}
			else
			{
				$response->SetStatusCode(400, 'Arguments not found(limit[int], offset[int]) or Incorrect arguments type');
			}

			return $response;
		});
	}
	//
	//
	//
	public function SetPostFunctions()
	{
		$this->get('new', 1, function($args)
		{
			$response = new Response();
			$parametersArray = array(
				'name' => '',
				'placeType' => '',
				'city' => '',
				'commentary' => ''
			);
			if(Module::CheckArgs($parametersArray, $args))
			{
				$model = new regRequestsModel();
				$name = $args['name'];
				$placeType = $args['placeType'];
				$city = $args['city'];
				$commentary = $args['commentary'];

				if(isset($_SESSION['id']) && $model->AddRequest(
                                        $name,
                                        $placeType,
                                        $city ,
                                        $commentary,
                                        $_SESSION['id']
				))
				{
					$response->SetStatusCode(200, 'OK');
				}
				else
				{
					$response->SetStatusCode(201, 'Failed to create registration request');
				}
			}
			else
			{
				$response->SetStatusCode(400, 'Arguments not found(name[str],placeType[str],city[int],commentary[str]) or Incorrect arguments type');
			}

			return $response;
		});
                
                $this->get('confirm', 3, function($args)
		{
                    $response = new Response();
                    $parametersArray = array(
                            'requestId' => 'int'
                    );
                    if(Module::CheckArgs($parametersArray, $args))
                    {
                            $model = new regRequestsModel();
                            $requestId = $args['requestId'];
                            if($model->Confirm($requestId))
                            {
                                    $response->SetStatusCode(200, 'OK');
                            }
                            else
                            {
                                    $response->SetStatusCode(204, 'Failed to confirm request');
                            }
                    }
                    else
                    {
                            $response->SetStatusCode(400, 'Arguments not found(limit[str], offset[int]) or Incorrect arguments type');
                    }

                    return $response;
		});
                
                $this->get('delete', 3, function($args)
		{
                    $response = new Response();
                    $parametersArray = array(
                            'requestId' => 'int'
                    );
                    if(Module::CheckArgs($parametersArray, $args))
                    {
                            $model = new regRequestsModel();
                            $requestId = $args['requestId'];
                            if($model->Delete($requestId))
                            {
                                    $response->SetStatusCode(200, 'OK');
                            }
                            else
                            {
                                    $response->SetStatusCode(204, 'Failed to delete request');
                            }
                    }
                    else
                    {
                            $response->SetStatusCode(400, 'Arguments not found(limit[str], offset[int]) or Incorrect arguments type');
                    }

                    return $response;
		});
	}

}