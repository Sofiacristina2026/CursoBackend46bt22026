<?php declare(strict_types=1); ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo de Produtos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background: #fafafa;
        }
        h1 {
            color: #1a73e8;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }
        th {
            background: #eee;
        }
        a {
            color: #1a73e8;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
        .btn {
            padding: 6px 12px;
            cursor: pointer;
            border: 1px solid #ccc;
            background: #fff;
            border-radius: 4px;
        }
        .btn-excluir {
            background: #dc3545;
            color: #fff;
            border: none;
        }
        .btn-excluir:hover {
            background: #b52b3d;
        }
        .erro {
            color: #721c24;
            background: #f8d7da;
            padding: 10px;
            border: 1px solid #f5c6cb;
            margin: 10px 0;
        }
    </style>
</head>
<body>
