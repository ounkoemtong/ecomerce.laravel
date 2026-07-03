import 'dart:convert';
import 'package:http/http.dart' as http;
import '../models/product.dart';

class TelegramService {
  static const String botToken = '8579876757:AAGReZd33ozFRHhrKjTh8XUvwJ4UCcOAmqw';
  static const String chatId = '7125153160';

  static Future<String> sendCheckoutMessage(List<Product> cartItems, double total) async {
    if (cartItems.isEmpty) return 'Cart is empty';

    final url = Uri.parse('https://api.telegram.org/bot$botToken/sendMessage');
    
    final StringBuffer message = StringBuffer();
    message.writeln('🛍 <b>NEW ORDER RECEIVED</b>');
    message.writeln('--------------------------------');
    
    for (var item in cartItems) {
      message.writeln('▪️ ${item.name} - \$${item.price.toStringAsFixed(2)}');
    }
    
    message.writeln('--------------------------------');
    message.writeln('💰 <b>Total: \$${total.toStringAsFixed(2)}</b>');

    try {
      final response = await http.post(
        url,
        headers: {'Content-Type': 'application/json'},
        body: jsonEncode({
          'chat_id': chatId,
          'text': message.toString(),
          'parse_mode': 'HTML',
        }),
      );
      
      if (response.statusCode != 200) {
        print('Telegram API Error: ${response.statusCode} - ${response.body}');
        return 'Telegram Error: ${response.statusCode}';
      }
      return 'OK';
    } catch (e) {
      print('Error sending telegram message: $e');
      return 'Network Error: $e';
    }
  }
}
