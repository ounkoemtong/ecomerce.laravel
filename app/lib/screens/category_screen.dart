import 'package:flutter/material.dart';
import '../constants/app_colors.dart';
import '../constants/app_typography.dart';
import '../widgets/product_card.dart';
import '../services/mock_data_service.dart';
import 'product_detail_screen.dart';

class CategoryScreen extends StatelessWidget {
  final String categoryName;

  const CategoryScreen({super.key, required this.categoryName});

  @override
  Widget build(BuildContext context) {
    // Collect all products and filter by category
    final allProducts = [
      ...MockDataService.newArrivals,
      ...MockDataService.trendingProducts,
      ...MockDataService.completeTheLook,
    ];
    
    // Simple filter by category string (case-insensitive for basic matching)
    final filteredProducts = allProducts.where((p) => 
      p.category.toLowerCase().contains(categoryName.toLowerCase())
    ).toSet().toList(); // toSet() to remove duplicates if any

    return Scaffold(
      backgroundColor: AppColors.white,
      appBar: AppBar(
        backgroundColor: AppColors.white,
        elevation: 0,
        centerTitle: true,
        leading: IconButton(
          icon: const Icon(Icons.arrow_back_ios, color: AppColors.black, size: 20),
          onPressed: () => Navigator.pop(context),
        ),
        title: Text(
          categoryName.toUpperCase(),
          style: AppTypography.heading2.copyWith(fontSize: 20, letterSpacing: 2),
        ),
      ),
      body: filteredProducts.isEmpty
          ? Center(
              child: Text(
                'No products found in $categoryName',
                style: AppTypography.bodyMedium,
              ),
            )
          : GridView.builder(
              padding: const EdgeInsets.all(24.0),
              gridDelegate: const SliverGridDelegateWithFixedCrossAxisCount(
                crossAxisCount: 2,
                childAspectRatio: 0.55,
                crossAxisSpacing: 16,
                mainAxisSpacing: 24,
              ),
              itemCount: filteredProducts.length,
              itemBuilder: (context, index) {
                final product = filteredProducts[index];
                return ProductCard(
                  product: product,
                  onTap: () {
                    Navigator.push(
                      context,
                      MaterialPageRoute(
                        builder: (_) => ProductDetailScreen(product: product),
                      ),
                    );
                  },
                );
              },
            ),
    );
  }
}
