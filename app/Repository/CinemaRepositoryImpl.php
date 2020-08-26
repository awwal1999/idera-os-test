<?php


namespace App\Repository;


use App\Models\Cinema;
use App\Models\Show;
use App\RepositoryContracts\CinemaRepository;

class CinemaRepositoryImpl implements CinemaRepository
{
    /**
     * @var Cinema
     */
    private $cinema;

    /**
     * CinemaRepositoryImpl constructor.
     * @param  Cinema  $cinema
     */
    public function __construct(Cinema $cinema)
    {
        $this->cinema = $cinema;
    }

    public function getCinemas()
    {
        return $this->cinema->newQuery()->get();
    }

    public function findById($id)
    {
        return $this->cinema->newQuery()->find($id);
    }

    public function addShow(Cinema $cinema, Show $show, $showTime)
    {
        return $cinema->shows()->attach($show->id, [
            "show_time" => $showTime
        ]);
    }

    public function findByShowABetweenStartDateAndEndDate(Show $show, $startDate, $endDate)
    {
        $builder = $this->cinema->newQuery()
            ->join('cinema_show', 'cinema_show.cinema_id', '=', 'cinemas.id')
            ->where('cinema_show.show_id', $show->id);
        optional($startDate, function ($startDate) use ($builder) {
            $builder->where('cinema_show.show_time', '>=', $startDate);
        });
        optional($endDate, function ($endDate) use ($builder) {
            $builder->where('cinema_show.show_time', '<=', $endDate);
        });

        return $builder->get('cinemas.*');
    }
}
