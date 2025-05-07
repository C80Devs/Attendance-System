<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\AttendanceModel;

class ImportCsvData extends Command
{
    protected $signature = 'csv:import-data';
    protected $description = 'Import users and attendance records from CSV files';

    public function handle()
    {
        $userCsv = public_path('employees.csv');
        $attendanceCsv = public_path('ivms_import_x.csv');

        if (!file_exists($userCsv) || !file_exists($attendanceCsv)) {
            Log::error('CSV files not found.');
            $this->error('CSV files not found.');
            return 1;
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        User::truncate();
        AttendanceModel::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $users = [];
        if (($handle = fopen($userCsv, 'r')) !== false) {
            $header = fgetcsv($handle);
            while (($data = fgetcsv($handle)) !== false) {
                $record = array_combine($header, $data);
                if (!isset($record['personId']) || empty($record['personId'])) continue;

                $names = explode(' ', trim($record['personName']));
                $firstName = array_shift($names);
                $lastName = implode(' ', $names);

                $email = $record['email'] ?? null;
                $phone = $record['phone'] ?? null;
                $email = trim($email);

                if (empty($email)) {
                    $email = strtolower(preg_replace('/\s+/', '', $lastName . $firstName . $record['personId']) . '@nilds.gov.ng');
                }

                if (empty($phone)) {
                    $phone = '090' . random_int(000000001, 999999999);
                }

                $user = User::updateOrCreate(
                    ['id' => $record['personId']],
                    [
                        'email' => $email,
                        'firstName' => $firstName,
                        'lastName' => $lastName,
                        'phone' => $phone,
                        'password' => Hash::make('12345678'),
                        'address' => '',
                        'date_of_birth' => null,
                        'nok_name' => '',
                        'nok_address' => '',
                        'nok_phone' => '',
                        'nok_email' => '',
                        'is_hybrid' => false,
                        'days' => [],
                        'active' => true,
                        'fingerprints' => null,
                        'faces' => null,
                    ]
                );

                $users[$record['personId']] = $user->id;
            }
            fclose($handle);
        } else {
            Log::error('Failed to open user CSV: ' . $userCsv);
            $this->error('Failed to open user CSV.');
            return 1;
        }

        $seen = [];
        if (($handle = fopen($attendanceCsv, 'r')) !== false) {
            $header = fgetcsv($handle);
            while (($data = fgetcsv($handle)) !== false) {
                $record = array_combine($header, $data);
                $personId = $record['personId'];
                $datetime = $record['datetime'];

                if (!isset($users[$personId])) {
                    Log::warning("Skipping attendance for unknown user: " . $personId);
                    continue;
                }

                $dateOnly = date('Y-m-d', strtotime($datetime));
                $uniqueKey = $personId . '_' . $dateOnly;

                if (isset($seen[$uniqueKey])) {
                    Log::info("Duplicate attendance for user: " . $personId . " on " . $dateOnly);
                    continue;
                }
                $seen[$uniqueKey] = true;

                try {
                    AttendanceModel::create([
                        'userID' => $users[$personId],
                        'device' => $record['checkpoint'] ?? '',
                        'clockin_location' => $record['checkpoint'] ?? '',
                        'clockout_location' => '',
                        'clockIn' => $datetime,
                        'clockOut' => null,
                        // 'face' => null,
                        'type' => $record['status'] ?? 'Check-in',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                } catch (\Exception $e) {
                    Log::error('Error creating attendance for user ' . $personId . ': ' . $e->getMessage());
                    $this->error('Error creating attendance for user ' . $personId);
                    return 1;
                }
            }
            fclose($handle);
        } else {
            Log::error('Failed to open attendance CSV: ' . $attendanceCsv);
            $this->error('Failed to open attendance CSV.');
            return 1;
        }

        Log::info('Import completed successfully.');
        $this->info('Import completed successfully.');
        return 0;
    }
}
