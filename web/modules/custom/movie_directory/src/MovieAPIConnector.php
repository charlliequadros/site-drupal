<?php
namespace Drupal\movie_directory;

use Drupal\Core\Http\ClientFactory;
 use Drupal\movie_directory\Form\MovieApi;
 use Guzz\Http\exception\RequestException;

class MovieAPIConnector {

    private $client;

    private $query;

    public function __construct(ClientFactory $client){
        $movie_api_config = \Drupal::state()->get(MovieApi::MOVIE_API_CONFIG_PAGE);
        $api_url = ($movie_api_config['api_base_url']) ?: 'https://api.themoviedb.org';
        $api_key = ($movie_api_config['api_key']) ?: '';

        $query = ['api_key' => $api_key];

        $this->query = $query;

        $this->client = $client->fromOptions(
            [
                'base_uri' => $api_url,
                'query' => $query
            ]
        );

    }

    public function discoverMovies(){
        $data =[];
        $endpoint = '/3/discover/movie';

        $options = ['query' => $this->query];
       

        try{
            $request = $this->client->get($endpoint, $options);
            $result = $request->getbody()->getContents();
            $data = json_decode($result);
        }catch(RequestException $e){
            watchdog_exception('movie_directory', $e,$e->getMessage());

        }
        return $data;

    }

    public function getImageUrl($image_path){
        return 'https://image.tmdb.org/t/p/w500/' . $image_path;
    }

}