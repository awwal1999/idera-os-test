<?php


namespace App\Http\Controllers;


use App\Exceptions\NotFoundException;
use App\Http\Requests\CreateShowsRequest;
use App\Http\Requests\GetShowsCinemaRequest;
use App\Models\Show;
use App\Repository\CinemaShowRepositoryImpl;
use App\RepositoryContracts\CinemaRepository;
use App\RepositoryContracts\CinemaShowRepository;
use App\RepositoryContracts\ShowRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ShowController extends BaseController
{
    /**
     * @var ShowRepository
     */
    private $showRepository;
    /**
     * @var CinemaShowRepository
     */
    private $cinemaShowRepository;


    /**
     * ShowController constructor.
     * @param  ShowRepository  $showRepository
     * @param  CinemaRepository  $cinemaRepository
     * @param  CinemaShowRepository  $cinemaShowRepository
     */
    public function __construct(
        ShowRepository $showRepository,
        CinemaShowRepository $cinemaShowRepository
    ) {
        $this->showRepository = $showRepository;
        $this->cinemaShowRepository = $cinemaShowRepository;
    }

    public
    function getShows(
        Request $request
    ) {
        $startDate = $request->startDate;
        $endDate = $request->endDate;
        $shows = $this->showRepository->getShows($startDate, $endDate);
        return $this->successfulResponse(200, $shows);
    }

    public
    function createShows(
        CreateShowsRequest $request
    ) {
        $show = $this->showRepository->createShow($request->all());
        return $this->successfulResponse(200, $show);
    }

    public function getCinemas(GetShowsCinemaRequest $request, $id)
    {
        $show = $this->showRepository->findById($id);

        if (!$show) {
            throw new NotFoundException('Show with Id cannot be found');
        }
        $cinemaShows = $this->cinemaShowRepository->findByShowAndStartDateAndEndDate($show,
            $request->startDate, $request->endDate);
        $cinemaShows = $cinemaShows->transform(function ($cinemaShow) {
            return [
                'show_time' => $cinemaShow->show_time,
                'cinema' => [
                    "name" => $cinemaShow->cinema->name,
                    'address' => $cinemaShow->cinema->address,
                    'id' => $cinemaShow->cinema->address
                ]
            ];
        });
        return $this->successfulResponse(200, $cinemaShows);
    }
}
