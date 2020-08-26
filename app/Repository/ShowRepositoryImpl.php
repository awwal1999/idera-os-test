<?php


namespace App\Repository;


use App\Models\Cinema;
use App\Models\Show;
use App\RepositoryContracts\ShowRepository;
use Carbon\Carbon;

class ShowRepositoryImpl implements ShowRepository
{
    /**
     * @var Show
     */
    private $show;

    /**
     * ShowRepositoryImpl constructor.
     * @param  Show  $show
     */
    public function __construct(Show $show)
    {
        $this->show = $show;
    }

    public function getShows($startDate, $endDate)
    {
        $queryBuilder = $this->show->newQuery();

        optional($startDate, function ($startDate) use ($queryBuilder) {
            $startDate = Carbon::createFromFormat('Y-m-d', $startDate)->startOfDay()->toDateTime();
            $queryBuilder->where('cinema_show.show_time', '>=', $startDate);
        });
        optional($endDate, function ($endDate) use ($queryBuilder) {
            $endDate = Carbon::createFromFormat('Y-m-d', $endDate)->startOfDay()->toDateTime();
            $queryBuilder->where('cinema_show.show_time', '<=', $endDate);
        });

        return $queryBuilder->paginate(20);
    }

    public function createShow($showRequest)
    {
        $showRequest = (object)$showRequest;
        $show = new Show();
        $show->name = $showRequest->name;
        $show->description = $showRequest->description;
        $show->save();
        return $show;
    }

    public function findById($id)
    {
        return $this->show->newQuery()->find($id);
    }

    /**
     * @param  Cinema  $cinema
     * @param $startDate
     * @param $endDate
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function findByCinemaAndStartDateOrEndDate(Cinema $cinema, $startDate, $endDate)
    {
        $builder = $this->show->newQuery()
            ->join('cinema_show', 'cinema_show.show_id', '=', 'shows.id')
            ->where('cinema_show.cinema_id', $cinema->id);
        optional($startDate, function ($startDate) use ($builder) {
            $builder->where('cinema_show.show_time', '>=', $startDate);
        });
        optional($endDate, function ($endDate) use ($builder) {
            $builder->where('cinema_show.show_time', '<=', $endDate);
        });

        return $builder->get();
    }
}
