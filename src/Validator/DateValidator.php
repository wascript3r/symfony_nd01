<?php

namespace App\Validator;

class DateValidator
{
	private const DATE_FORMAT = 'Y-m-d';

	/**
	 * @param string $day
	 * @return string
	 */
	public function getError(string $day): ?string
	{
		try {
			$date = new \DateTime($day);
			if ($this->compareTo($date, new \DateTime()) === -1) {
				return 'Data turi būti ne senesnė kaip šiandienos!';
			} elseif ($this->compareTo($date, new \DateTime('now +2 months')) === 1) {
				return 'Data turi būti ne vėlesnė kaip 2 mėnesių laikotarpio!';
			}
			return null;
		} catch (\Exception $e) {
			return 'Neteisingas datos formatas!';
		}
	}

	/**
	 * @param \DateTime $date1
	 * @param \DateTime $date2
	 * @return int
	 */
	private function compareTo(\DateTime $date1, \DateTime $date2)
	{
		return $date1->format(self::DATE_FORMAT) <=> $date2->format(self::DATE_FORMAT);
	}
}