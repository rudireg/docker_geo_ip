<?php
/**
 * @copyright Copyright (c) 2019 Eduard Rudakan.
 * @author    Eduard Rudakan <rudiwork@ya.ru>
 * Project: geo_ip
 * File: GeoIpCommand.php
 * Date: 23.05.19
 * Time: 22:22
 */
namespace App\Command;

use App\Repository\IpsRepository;
use Symfony\Component\Lock\Factory;
use App\Ip\Manager;
use Symfony\Component\Lock\Store\FlockStore;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * CRON: 0 0 * * * /app/bin/console app:rebuild_geo_ip
 *
 * DOCKER: docker exec -it 212158b443a2 php /app/bin/console app:rebuild_geo_ip
 *
 * Class GeoIpCommand
 * @package App\Command
 */
class GeoIpCommand extends Command
{
    /**
     * @var Manager
     */
    private $manager;
    /**
     * @var IpsRepository
     */
    private $ipRepository;

    /**
     * GeoIpCommand constructor.
     * @param Manager $manager
     * @param IpsRepository $ipRepository
     * @param string|null $name
     */
    public function __construct(Manager $manager, IpsRepository $ipRepository, string $name = null)
    {
        parent::__construct($name);
        $this->manager = $manager;
        $this->ipRepository = $ipRepository;
    }

    /**
     * Config
     */
    protected function configure()
    {
        $this->setName('app:rebuild_geo_ip')
            ->setDescription('Update Geo IP data.');
    }

    /**
     * Перепроверка списка IP адресов
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|void|null
     * @throws \Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $store = new FlockStore(sys_get_temp_dir());
        $factory = new Factory($store);
        $lock = $factory->createLock('start-geo-ip-recheck');
        // запрещаем выполнение скрипта, если еще прошлый запуск не завершился
        if ($lock->acquire()) {
            // Получить список IP
            $ips = $this->ipRepository->getIpList();
            // Перепроверить полученный список IP
            foreach ($ips AS $ip) {
                $rv = $this->manager->detectGeoIp($ip);
                $output->writeln($rv);
            };
            $lock->release();
        }
    }
}