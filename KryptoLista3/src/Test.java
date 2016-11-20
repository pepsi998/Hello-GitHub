import java.io.File;
import java.io.IOException;
import java.security.InvalidAlgorithmParameterException;
import java.security.InvalidKeyException;
import java.security.NoSuchAlgorithmException;
import java.util.Scanner;

import javax.crypto.BadPaddingException;
import javax.crypto.Cipher;
import javax.crypto.IllegalBlockSizeException;
import javax.crypto.NoSuchPaddingException;
import javax.swing.JPanel;

public class Test {

	private static String [] ALGORITHM = {"AES", "DES"};
	private static String [] SCHEME = {"CBC","CTR","GCM","ECB"};
	
	public static void main(String[] args) throws IOException, InvalidKeyException, NoSuchAlgorithmException, NoSuchPaddingException, IllegalBlockSizeException, BadPaddingException, InvalidAlgorithmParameterException, FileDoesntExistException	{
		
		Scanner scan = new Scanner(System.in);
		File f = new File("keystore");
		// Czy keystore istneje
		if(!f.exists()) 
		    Crypt.EncodeKeyStore(new File("klucze.txt"), "keystore");
		//czy config z haslem istnieje
		CheckPassword.CheckFile("config");

		
		
		String password;
		do{
			System.out.println("Podaj poprawne has³o:");
			password = scan.nextLine();
		}while(!Crypt.DecodePassword(password));
		
		int x;
		int algorith;
		int scheme;
		int keyNumber;
		String fileName;
		do{
			System.out.println("1. Kodowanie pliku\n2. Odkodowanie pliku \n0. WYJSCIE");
			x = scan.nextInt();
			switch(x)	{
			case 1:
				System.out.println("Wybrano kodowanie wybierz plik do zakodowania");
				scan.nextLine();
				fileName = scan.nextLine();
				System.out.println("Algorytm 1.AES 2.ECB");
				algorith = scan.nextInt()-1;
				System.out.println("Tryb kodowania: 1.CBC 2.CTR 3.GCM 4.ECB");
				scheme = scan.nextInt()-1;
				System.out.println("Numer klucza 0-4");
				keyNumber = scan.nextInt()%5;
				Crypt.doCrypt(new File(fileName), new File(fileName+".encoded"), keyNumber, Cipher.ENCRYPT_MODE, ALGORITHM[algorith], SCHEME[scheme]);
				break;
			case 2:
				System.out.println("Wybrano dekodowanie wybierz plik do odkowowania");
				scan.nextLine();
				fileName = scan.nextLine();
				System.out.println("Algorytm 1.AES 2.ECB");
				algorith = scan.nextInt()-1;
				System.out.println("Tryb kodowania: 1.CBC 2.CTR 3.GCM 4.ECB");
				scheme = scan.nextInt()-1;
				System.out.println("Numer klucza 0-4");
				keyNumber = scan.nextInt()%5;
				Crypt.doCrypt(new File(fileName+".encoded"), new File(fileName), keyNumber, Cipher.DECRYPT_MODE, ALGORITHM[algorith], SCHEME[scheme]);

				break;
			case 0:
				System.out.println("Wyjcie");
				break;
			default:
				System.out.println("Brak reakcji na klawisz");
				break;
			}
		}while(x!=0);
	}
	
}