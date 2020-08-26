<?php


namespace App\Repository;


use App\Models\Cinema;
use App\Models\CinemaShow;
use App\Models\Show;
use App\RepositoryContracts\CinemaShowRepository;
use Carbon\Carbon;

class CinemaShowRepositoryImpl implements CinemaShowRepository
{
    /**
     * @var CinemaShow
     */
    private $cinemaShow;

    /**
     * CinemaShowRepositoryImpl constructor.
     * @param  CinemaShow  $cinemaShow
     */
    public function __construct(CinemaShow $cinemaShow)
    {
        $this->cinemaShow = $cinemaShow;
    }

    public function findByShowAndStartDateAndEndDate(Show $show, $startDate, $endDate)
    {
        $builder = $this->cinemaShow->newQuery()->with('cinema')
            ->where('cinema_show.show_id', $show->id);

        optional($startDate, function ($startDate) use ($builder) {
            $startDate = Carbon::createFromFormat('Y-m-d', $startDate)->startOfDay()->toDateTime();
            $builder->where('cinema_show.show_time', '>=', $startDate);
        });
        optional($endDate, function ($endDate) use ($builder) {
            $endDate = Carbon::createFromFormat('Y-m-d', $endDate)->endOfDay()->toDateTime();
            $builder->where('cinema_show.show_time', '<=', $endDate);
        });

        return $builder->get();
    }

    public function findByCinemasAndStateDateAndEndDate(Cinema $cinema, $startDate, $endDate)
    {
        $builder = $this->cinemaShow->newQuery()->with('show')
            ->where('cinema_show.cinema_id', $cinema->id);

        optional($startDate, function ($startDate) use ($builder) {
            $startDate = Carbon::createFromFormat('Y-m-d', $startDate)->startOfDay()->toDateTime();
            $builder->where('cinema_show.show_time', '>=', $startDate);
        });
        optional($endDate, function ($endDate) use ($builder) {
            $endDate = Carbon::createFromFormat('Y-m-d', $endDate)->endOfDay()->toDateTime();
            $builder->where('cinema_show.show_time', '<=', $endDate);
        });
        return $builder->get();
    }
}
