<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UniversitySeeder extends Seeder
{
    /**
     * Each entry: [code, name, institution, location, state, login_slug]
     * login_slug drives the portal email: {slug}@yes-iem.org.my
     * Default password for all accounts: YesIem2026!
     */
    private array $universities = [
        ['UTAR-SL', 'YES UTAR Sungai Long',        'Universiti Tunku Abdul Rahman',                    'Sungai Long, Kajang', 'Selangor',          'utar'],
        ['MONASH',  'YES Monash Malaysia',           'Monash University Malaysia',                        'Bandar Sunway',       'Selangor',          'monash'],
        ['UNITEN',  'YES UNITEN',                    'Universiti Tenaga Nasional',                        'Kajang',              'Selangor',          'uniten'],
        ['MMU-CJ',  'YES MMU Cyberjaya',             'Multimedia University',                             'Cyberjaya',           'Selangor',          'mmu'],
        ['UITM-SA', 'YES UiTM Shah Alam',            'Universiti Teknologi MARA',                        'Shah Alam',           'Selangor',          'uitm'],
        ['UKM',     'YES UKM',                       'Universiti Kebangsaan Malaysia',                   'Bangi',               'Selangor',          'ukm'],
        ['TAYLORS', 'YES Taylor\'s University',      'Taylor\'s University',                              'Subang Jaya',         'Selangor',          'taylors'],
        ['UM',      'YES UM',                        'Universiti Malaya',                                 'Kuala Lumpur',        'Kuala Lumpur',      'um'],
        ['IUKL',    'YES IUKL',                      'Infrastructure Universiti Kuala Lumpur',           'Kuala Lumpur',        'Kuala Lumpur',      'iukl'],
        ['UNMC',    'YES UNMC',                      'The University of Nottingham Malaysia Campus',      'Semenyih',            'Selangor',          'unmc'],
        ['SEGI',    'YES SEGi University',            'SEGi University',                                   'Kota Damansara',      'Selangor',          'segi'],
        ['MAHSA',   'YES MAHSA University',           'MAHSA University',                                  'Jenjarom',            'Selangor',          'mahsa'],
        ['UOWKDU',  'YES UOW KDU',                   'UOW KDU University College',                        'Petaling Jaya',       'Selangor',          'uowkdu'],
        ['UPM',     'YES UPM',                       'Universiti Putra Malaysia',                         'Serdang',             'Selangor',          'upm'],
        ['XMUM',    'YES XMUM',                      'Xiamen University Malaysia',                        'Sepang',              'Selangor',          'xmum'],
        ['SUNWAY',  'YES Sunway University',          'Sunway University',                                 'Subang Jaya',         'Selangor',          'sunway'],
        ['APU',     'YES APU',                       'Asia Pacific University of Technology & Innovation','Kuala Lumpur',        'Kuala Lumpur',      'apu'],
        ['UCSI',    'YES UCSI University',            'UCSI University',                                   'Kuala Lumpur',        'Kuala Lumpur',      'ucsi'],
        ['TARUMT',  'YES TAR UMT',                   'Tunku Abdul Rahman University of Management and Technology', 'Kuala Lumpur', 'Kuala Lumpur', 'tarumt'],
        ['IIUM',    'YES IIUM',                       'International Islamic University Malaysia',          'Gombak',              'Selangor',          'iium'],
        ['HWUM',    'YES HWUM',                       'Heriot-Watt University Malaysia',                   'Putrajaya',           'Kuala Lumpur',      'hwum'],
    ];

    public function run(): void
    {
        $defaultPassword = Hash::make('YesIem2026!');

        foreach ($this->universities as [$code, $name, $institution, $location, $state, $slug]) {
            $branch = Branch::updateOrCreate(
                ['code' => $code],
                [
                    'name'         => $name,
                    'institution'  => $institution,
                    'location'     => $location,
                    'state'        => $state,
                    'status'       => 'active',
                    'is_active'    => true,
                    'academic_year'=> '2025/2026',
                    'member_count' => 0,
                ]
            );

            User::updateOrCreate(
                ['email' => "{$slug}@yes-iem.org.my"],
                [
                    'name'      => "{$name} Admin",
                    'password'  => $defaultPassword,
                    'branch_id' => $branch->id,
                    'role'      => 'branch_admin',
                    'status'    => 'active',
                ]
            );
        }

        $this->command->info('✓ ' . count($this->universities) . ' university branches + accounts seeded.');
        $this->command->table(
            ['Code', 'Branch', 'Login Email', 'Password'],
            array_map(
                fn ($u) => [$u[0], $u[1], "{$u[5]}@yes-iem.org.my", 'YesIem2026!'],
                $this->universities
            )
        );
    }
}
