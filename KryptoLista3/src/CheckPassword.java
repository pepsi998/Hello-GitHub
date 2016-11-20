import java.io.Console;
import java.io.File;
import java.io.IOException;
import java.security.InvalidAlgorithmParameterException;
import java.security.InvalidKeyException;
import java.security.NoSuchAlgorithmException;
import java.util.Scanner;

import javax.crypto.BadPaddingException;
import javax.crypto.IllegalBlockSizeException;
import javax.crypto.NoSuchPaddingException;
/**
 * 
 * @author Scielu
 * Sprawdzanie czy plik istnieje i wpisanie hasla
 */
public class CheckPassword {

	private static Scanner scanner = new Scanner(System.in);
	
	public static void CheckFile(String path) throws IOException, InvalidKeyException, NoSuchAlgorithmException, NoSuchPaddingException, IllegalBlockSizeException, BadPaddingException, InvalidAlgorithmParameterException	{
		
		
		File file = new File(path);

		boolean isCreated = file.createNewFile();
	      if (isCreated)	{
	        System.out.println("1 logowanie podaj has³o: ");
	        Console console = System.console();
	        String password = scanner.nextLine();
	        Crypt.EncodePassword(password, file);
	      
	      }

	}	
	
}
