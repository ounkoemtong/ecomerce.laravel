import 'package:app/routes/MyApp.dart';
import 'package:flutter/material.dart';

void main (){
  runApp(const MyWidget());
}

class MyWidget extends StatelessWidget {
  const MyWidget({super.key});

  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      debugShowCheckedModeBanner: false,
      title: 'ATELIER',
      theme: ThemeData(
        scaffoldBackgroundColor: const Color(0xFFF8F8F8), // AppColors.background
      ),
      home: const Myapp(),
    );
  }
}