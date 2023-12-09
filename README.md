# Student Adaptability Level Prediction in Online Education

Original dataset https://www.kaggle.com/datasets/mdmahmudulhasansuzan/students-adaptability-level-in-online-education

Or you can get preproceed clean indonesian dataset here https://drive.google.com/drive/folders/1wIftVQ6OC2mtUoyiYKfbA-msBf_JRudI?usp=sharing

## Installation

You can clone the repository with this command, or download this [zip](https://github.com/rulyadhika/Student-Adaptability-Level-Prediction/archive/refs/heads/main.zip) file.

```bash
> git clone https://github.com/rulyadhika/Student-Adaptability-Level-Prediction.git
```

## Configuration
1. Change terminal directory to Student-Adaptability-Level-Prediction folder
```bash
> cd Student-Adaptability-Level-Prediction
```

2. Run this command
```bash
> composer install
```

3. Duplicate .env.example file and rename it to .env . Or you can run this command
```bash
> copy .env.example .env
```

4. Generate app key with this command
```bash
> php artisan key:generate
```

5. Configure your app_url and database in .env file

6. Ensure your database is setup correctly, then run this command
```bash
> php artisan migrate:fresh --seed
```

7. Run local development server
```bash
> php artisan serve
```